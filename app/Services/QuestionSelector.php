<?php

namespace App\Services;

use Illuminate\Support\Collection;

class QuestionSelector
{
    private const SUBJECT_REPEAT = 5;
    private const VERB_REPEAT    = 2;
    private const OBJECT_REPEAT  = 2;
    private const PLACE_REPEAT   = 2;
    private const TIME_REPEAT    = 2;
    public const  CANDIDATE_MULTIPLIER = 4;

    public function select(
        Collection $candidates,
        int $limit
    ): Collection {

        $shuffled      = $candidates->shuffle()->values();
        $result        = collect();
        $usedIds       = [];
        $subjects      = [];
        $verbs         = [];
        $objects       = [];
        $places        = [];
        $times         = [];
        $meaningHashes = [];

        // ── Pass 1: strict — full diversity filter ──
        foreach ($shuffled as $question) {

            if ($result->count() >= $limit) {
                break;
            }

            $keywords = $question->keywords ?? [];

            $subject = $keywords['subject'] ?? null;
            $verb    = $keywords['verb']    ?? null;
            $object  = $keywords['object']  ?? null;
            $place   = $keywords['place']   ?? null;
            $time    = $keywords['time']    ?? null;

            $hash = $question->meaning_hash ?? null;
            if ($hash && in_array($hash, $meaningHashes)) {
                continue;
            }

            if ($this->tooFrequent($subject, $subjects, self::SUBJECT_REPEAT)) continue;
            if ($this->tooFrequent($verb,    $verbs,    self::VERB_REPEAT))    continue;
            if ($this->tooFrequent($object,  $objects,  self::OBJECT_REPEAT))  continue;
            if ($this->tooFrequent($place,   $places,   self::PLACE_REPEAT))   continue;
            if ($this->tooFrequent($time,    $times,    self::TIME_REPEAT))    continue;

            $result->push($question);
            $usedIds[] = $question->id;

            if ($hash) {
                $meaningHashes[] = $hash;
            }

            $this->record($subject, $subjects);
            $this->record($verb,    $verbs);
            $this->record($object,  $objects);
            $this->record($place,   $places);
            $this->record($time,    $times);
        }

        // ── Pass 2: fallback — kalau strict pass belum cukup, isi sisa slot.
        // Diversity keyword-limit dilonggarin, tapi meaning_hash duplikat
        // tetap dicegah biar nggak ada 2 soal yang artinya sama persis.
        if ($result->count() < $limit) {
            foreach ($shuffled as $question) {

                if ($result->count() >= $limit) {
                    break;
                }

                if (in_array($question->id, $usedIds)) {
                    continue;
                }

                $hash = $question->meaning_hash ?? null;
                if ($hash && in_array($hash, $meaningHashes)) {
                    continue;
                }

                $result->push($question);
                $usedIds[] = $question->id;

                if ($hash) {
                    $meaningHashes[] = $hash;
                }
            }

            if ($result->count() < $limit) {
                logger()->warning(
                    "QuestionSelector: hanya dapet {$result->count()}/{$limit} soal "
                    . "meski udah fallback pass — kemungkinan kandidat kurang variatif atau kurang banyak."
                );
            }
        }

        return $result;
    }

    private function tooFrequent(?string $keyword, array $tracker, int $limit): bool
    {
        if (empty($keyword)) {
            return false;
        }

        $key = strtolower(trim($keyword));

        return ($tracker[$key] ?? 0) >= $limit;
    }


    private function record(?string $keyword, array &$tracker): void
    {
        if (empty($keyword)) {
            return;
        }

        $key = strtolower(trim($keyword));
        $tracker[$key] = ($tracker[$key] ?? 0) + 1;
    }
}