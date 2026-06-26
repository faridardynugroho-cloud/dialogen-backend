<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Player;
use App\Events\PlayerJoined;
use App\Events\SettingsUpdated;
use App\Events\PlayerLeft;
use App\Events\ChatMessageSent;
use App\Events\GameStarted;
use App\Events\ScoreUpdated;
use App\Events\PlayerOffline;

class RoomController extends Controller
{
    // ── POST /api/rooms
    // Flutter CreateRoom screen memanggil ini
    public function create(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:50',
            'uuid'     => 'required|string',
        ]);

        // Generate kode unik 6 karakter
        do {
            $code = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 6));
        } while (Room::where('code', $code)->exists());

        // Buat room
        $room = Room::create([
            'code'   => $code,
            'status' => 'waiting',
        ]);

        $player = Player::create([
            'uuid'           => $request->uuid,
            'username'       => $request->username,
            'room_id'        => $room->id,
            'is_host'        => true,
            'color_avatar' => $this->pickAvatarColor($room),
            'lobby_position' => 1,
        ]);

        // Update host_player_id di room
        $room->update(['host_player_id' => $player->id]);

        // Broadcast ke channel room.{code}
        // (host join duluan, tapi broadcast tetap dikirim supaya bisa di-test)
        $allPlayers = $this->formatPlayers($room->fresh()->load('players')->players);
        event(new PlayerJoined($room, $player, $allPlayers));

        return response()->json([
            'message'   => 'Room created',
            'room_code' => $room->code,
            'player_id' => $player->id,
            'is_host'   => true,
        ], 201);
    }

    // ── POST /api/rooms/{code}/join
    public function join(Request $request, string $code)
    {
        $request->validate([
            'username' => 'required|string|max:50',
            'uuid'     => 'required|string',
        ]);

        // Cari room
        $room = Room::where('code', strtoupper($code))->first();

        if (!$room) {
            return response()->json(['message' => 'Room tidak ditemukan'], 404);
        }

        if ($room->status !== 'waiting') {
            return response()->json(['message' => 'Game sudah dimulai'], 400);
        }

        if ($room->players()->where('is_online', true)->count() >= $room->max_players) {
            return response()->json([
                'message' => 'Lobby sudah penuh'
            ], 400);
        }

        $existingPlayer = $room->players()
            ->where('uuid', $request->uuid)
            ->first();

        if ($existingPlayer) {
            $existingPlayer->update([
                'username'  => $request->username,
            ]);

            $allPlayers = $this->formatPlayers($room->fresh()->players);
            event(new PlayerJoined($room, $existingPlayer, $allPlayers));

            return response()->json([
                'message'   => 'Rejoined room',
                'room_code' => $room->code,
                'player_id' => $existingPlayer->id,
                'is_host'   => (bool) $existingPlayer->is_host,
            ]);
        }

        // Cek username sudah dipakai di room ini
        $exists = $room->players()->where('username', $request->username)->exists();
        if ($exists) {
            return response()->json(['message' => 'Username sudah dipakai di room ini'], 400);
        }

        $position = $room->players()->count() + 1;

        $player = Player::create([
            'uuid'           => $request->uuid,
            'username'       => $request->username,
            'room_id'        => $room->id,
            'is_host'        => false,
            'color_avatar' => $this->pickAvatarColor($room),
            'lobby_position' => $position,
            'is_online'      => false,
        ]);

        $allPlayers = $this->formatPlayers($room->fresh()->players);
        event(new PlayerJoined($room, $player, $allPlayers));

        return response()->json([
            'message'   => 'Joined room',
            'room_code' => $room->code,
            'player_id' => $player->id,
            'is_host'   => false,
        ], 200);
    }

    // ── GET /api/rooms/{code}
    // Flutter Lobby screen memanggil ini saat pertama load
    public function show(string $code)
    {
        $room = Room::with('players')
            ->where('code', strtoupper($code))
            ->first();

        if (!$room) {
            return response()->json(['message' => 'Room tidak ditemukan'], 404);
        }

        return response()->json([
            'room_code'   => $room->code,
            'status'      => $room->status,
            'max_players' => $room->max_players,
            'category'    => $room->category,
            'time_limit'  => $room->time_limit,
            'players'     => $this->formatPlayers($room->players),
        ]);
    }

    // ── PATCH /api/rooms/{code}/settings
    public function updateSettings(Request $request, string $code)
    {
        $request->validate([
            'category'    => 'sometimes|string',
            'time_limit'  => 'sometimes|string',
            'max_players' => 'sometimes|integer|min:2|max:10',
        ]);

        $room = Room::where('code', strtoupper($code))->first();

        if (!$room) {
            return response()->json(['message' => 'Room tidak ditemukan'], 404);
        }

        $room->update($request->only(['category', 'time_limit', 'max_players']));

        event(new SettingsUpdated($room->fresh()));

        return response()->json(['message' => 'Settings updated']);
    }

    // ── POST /api/rooms/{code}/chat
    public function chat(Request $request, string $code)
    {
        $request->validate([
            'username' => 'required|string|max:50',
            'message'  => 'required|string|max:300',
        ]);

        $room = Room::where('code', strtoupper($code))->first();

        if (!$room) {
            return response()->json(['message' => 'Room tidak ditemukan'], 404);
        }

        event(new ChatMessageSent(
            room: $room,
            username: $request->username,
            message: $request->message,
            sentAt: now()->format('H:i'),
        ));

        return response()->json(['message' => 'Message sent']);
    }

    // ── DELETE /api/rooms/{code}/leave
    public function leave(Request $request, string $code)
    {
        $request->validate([
            'player_id' => 'required|integer',
        ]);

        $room = Room::with('players')->where('code', strtoupper($code))->first();

        if (!$room) {
            return response()->json(['message' => 'Room tidak ditemukan'], 404);
        }

        $leavingPlayer = $room->players()->find($request->player_id);

        if (!$leavingPlayer) {
            return response()->json(['message' => 'Player tidak ditemukan'], 404);
        }

        $wasHost = (bool) $leavingPlayer->is_host;

        $leavingPlayer->update([
            'is_online' => false,
        ]);

        $leavingPlayer->delete();

        // Refresh sisa players
        $remaining = $room->fresh()->players;

        $newHostId = null;

        if ($remaining->isEmpty()) {
            // Room kosong → hapus room
            $room->delete();
            return response()->json(['message' => 'Room deleted']);
        }

        if ($wasHost) {
            // Ambil player dengan lobby_position terkecil setelah host lama pergi
            $newHost = $remaining->sortBy('lobby_position')->first();
            $newHost->update(['is_host' => true]);
            $room->update(['host_player_id' => $newHost->id]);
            $newHostId = $newHost->id;
        }

        $allPlayers = $this->formatPlayers($room->fresh()->players);
        event(new PlayerLeft($room, $allPlayers, $newHostId));

        return response()->json(['message' => 'Left room']);
    }

    // ── POST /api/rooms/{code}/finish
    public function finish(Request $request, string $code)
    {
        $room = Room::where('code', strtoupper($code))->first();

        if (!$room) {
            return response()->json(['message' => 'Room tidak ditemukan'], 404);
        }

        $room->update(['status' => 'finished']);

        return response()->json(['message' => 'Game finished']);
    }

    // ── POST /api/rooms/{code}/reset
    public function reset(Request $request, string $code)
    {
        $room = Room::where('code', strtoupper($code))->first();

        if (!$room) {
            return response()->json(['message' => 'Room tidak ditemukan'], 404);
        }

        // Skip jika sudah waiting (player lain sudah reset duluan)
        if ($room->status === 'waiting') {
            return response()->json(['message' => 'Room sudah di-reset', 'skipped' => true]);
        }

        $room->update(['status' => 'waiting']);
        $room->players()->update(['score' => 0]);

        return response()->json(['message' => 'Room reset', 'skipped' => false]);
    }
    // Helper: format players untuk response
    private function formatPlayers($players): array
    {
        return $players->map(fn($p) => [
            'id'       => $p->id,
            'username' => $p->username,
            'is_host'  => (bool) $p->is_host,
            'score'    => $p->score,
            'is_online' => (bool)$p->is_online,
            'color_avatar'   => $p->color_avatar ?? '#FFB4B4',
            'lobby_position' => $p->lobby_position ?? 0,
        ])->values()->toArray();
    }

    public function start(Request $request, string $code)
    {
        $room = Room::where('code', strtoupper($code))->first();

        if (!$room) {
            return response()->json(['message' => 'Room tidak ditemukan'], 404);
        }

        if ($room->players()->count() < 2) {
            return response()->json(['message' => 'Minimal 2 player'], 400);
        }

        // reset skor disini
        $room->players()->update([
            'score' => 0,
        ]);

        $room->update([
            'status' => 'playing'
        ]);

        event(new GameStarted($room));

        return response()->json([
            'message' => 'Game started'
        ]);
    }

    public function submitScore(Request $request, string $code)
    {
        $request->validate([
            'username'        => 'required|string|max:50',
            'score'           => 'required|integer|min:0',
            'question_number' => 'required|integer|min:1',
        ]);

        $room = Room::with('players')->where('code', strtoupper($code))->first();

        if (!$room) {
            return response()->json(['message' => 'Room tidak ditemukan'], 404);
        }

        // Update skor player di DB
        $room->players()
            ->where('username', $request->username)
            ->update(['score' => $request->score]);

        // Ambil semua skor terbaru
        $scores = $room->fresh()->players
            ->map(fn($p) => [
                'username' => $p->username,
                'score'    => $p->score,
            ])
            ->values()
            ->toArray();

        event(new ScoreUpdated($room, $scores, $request->question_number));

        return response()->json(['message' => 'Score updated']);
    }

    public function rejoin(Request $request, string $code)
    {
        $request->validate([
            'uuid' => 'required|string',
        ]);

        $room = Room::with('players')
            ->where('code', strtoupper($code))
            ->first();

        if (!$room) {
            return response()->json(['message' => 'Room tidak ditemukan'], 404);
        }

        $player = $room->players()
            ->where('uuid', $request->uuid)
            ->first();

        if (!$player) {
            return response()->json(['message' => 'Player tidak ditemukan'], 404);
        }


        $player->update([
            'is_online' => true,
        ]);

        $room = $room->fresh()->load('players');

        $allPlayers = $this->formatPlayers($room->players);

        event(new PlayerJoined($room, $player, $allPlayers));

        return response()->json([
            'message' => 'OK',
            'is_host' => (bool)$player->is_host,
        ]);
    }

    public function setOffline(Request $request, string $code)
    {
        $request->validate([
            'player_id' => 'required|integer'
        ]);

        $room = Room::with('players')
            ->where('code', strtoupper($code))
            ->first();

        if (!$room) {
            return response()->json([
                'message' => 'Room tidak ditemukan'
            ], 404);
        }

        $player = $room->players()
            ->where('id', $request->player_id)
            ->first();

        if (!$player) {
            return response()->json([
                'message' => 'Player tidak ditemukan'
            ], 404);
        }

        $player->update([
            'is_online' => false,
        ]);

        // refresh player list
        $room = $room->fresh()->load('players');

        $allPlayers = $this->formatPlayers($room->players);

        event(new PlayerOffline(
            room: $room,
            username: $player->username,
            allPlayers: $allPlayers,
            newHostId: null,
        ));

        return response()->json([
            'success' => true,
        ]);
    }

    public function checkUsername(Request $request, string $code)
    {
        $request->validate([
            'username' => 'required|string|max:50',
        ]);

        $room = Room::where('code', strtoupper($code))->first();

        if (!$room) {
            return response()->json(['available' => false, 'message' => 'Room tidak ditemukan'], 404);
        }

        $taken = $room->players()
            ->where('username', $request->username)
            ->exists();

        return response()->json(['available' => !$taken]);
    }
    // Tambah helper method ini di RoomController
    private function pickAvatarColor(Room $room): string
    {
        $avatarColors = [
            '#FFB4B4',
            '#FFD37A',
            '#9FFFCB',
            '#9FD6FF',
            '#D4B4FF',
            '#FFB4E6',
            '#FF9E7A',
            '#B4FFD4',
            '#7AB8FF',
            '#FFE4B4',
            '#C4B4FF',
            '#B4F0FF',
            '#FFCCE0',
            '#B4FFEC',
            '#FFD9B4',
            '#B4D4FF',
            '#E8FFB4',
            '#FFB4C8',
            '#B4FFB4',
            '#F0B4FF',
        ];

        $used = $room->players()->pluck('color_avatar')->toArray();
        $available = array_values(array_diff($avatarColors, $used));

        if (empty($available)) {
            // Fallback kalau semua warna habis (>20 player)
            return $avatarColors[array_rand($avatarColors)];
        }

        return $available[array_rand($available)];
    }
}
