<?php

namespace App\Repositories;

use App\Core\Repository;

class SevaRepository extends Repository
{
    protected string $table = 'sevas';

    public function categories(): array
    {
        return [
            'শিশু', 'শিক্ষার্থী', 'মা', 'গর্ভবতী নারী', 'নববিবাহিত দম্পতি', 'কিশোরী',
            'প্রবীণ', 'অসুস্থ মানুষ', 'দরিদ্র পরিবার', 'প্রতিবন্ধী ব্যক্তি', 'প্রাণী',
            'পরিবেশ', 'শিক্ষা', 'খাদ্য', 'স্বাস্থ্য', 'বই', 'বৃক্ষরোপণ', 'রক্তদান',
            'সময়দান', 'দক্ষতা দিয়ে সাহায্য', 'কমিউনিটি সেবা',
        ];
    }

    /**
     * Filter by beneficiary/category, difficulty, budget bucket and time bucket.
     * All filters are optional; budget/time buckets map to numeric ranges.
     */
    public function filter(array $filters, int $page = 1, int $perPage = 12): array
    {
        $clauses = ["status = 'active'"];
        $params = [];

        if (!empty($filters['category'])) {
            $clauses[] = 'category = :category';
            $params['category'] = $filters['category'];
        }

        if (!empty($filters['difficulty'])) {
            $clauses[] = 'difficulty = :difficulty';
            $params['difficulty'] = $filters['difficulty'];
        }

        if (!empty($filters['day'])) {
            $clauses[] = 'navadurga_day = :day';
            $params['day'] = (int) $filters['day'];
        }

        if (!empty($filters['budget'])) {
            [$min, $max] = $this->budgetRange($filters['budget']);
            if ($max === null) {
                $clauses[] = 'estimated_cost_min >= :budget_min';
                $params['budget_min'] = $min;
            } else {
                $clauses[] = '(estimated_cost_min <= :budget_max AND (estimated_cost_max IS NULL OR estimated_cost_max >= :budget_min))';
                $params['budget_min'] = $min;
                $params['budget_max'] = $max;
            }
        }

        if (!empty($filters['time'])) {
            $maxMinutes = $this->timeMaxMinutes($filters['time']);
            if ($maxMinutes !== null) {
                $clauses[] = 'time_required_minutes <= :time_minutes';
                $params['time_minutes'] = $maxMinutes;
            }
        }

        $where = 'WHERE ' . implode(' AND ', $clauses);
        $total = (int) $this->query("SELECT COUNT(*) AS c FROM sevas {$where}", $params)[0]['c'];
        $offset = ($page - 1) * $perPage;

        $rows = $this->query(
            "SELECT * FROM sevas {$where} ORDER BY navadurga_day ASC, title_bn ASC LIMIT {$perPage} OFFSET {$offset}",
            $params
        );

        return [
            'data' => $rows,
            'total' => $total,
            'page' => $page,
            'last_page' => max(1, (int) ceil($total / $perPage)),
        ];
    }

    protected function budgetRange(string $bucket): array
    {
        return match ($bucket) {
            '0-100' => [0, 100],
            '100-500' => [100, 500],
            '500-1000' => [500, 1000],
            '1000+' => [1000, null],
            default => [0, null],
        };
    }

    protected function timeMaxMinutes(string $bucket): ?int
    {
        return match ($bucket) {
            '15min' => 15,
            '30min' => 30,
            '1hour' => 60,
            'half_day' => 240,
            'full_day' => 480,
            'long_term' => null,
            default => null,
        };
    }

    /**
     * "আজ আমি কী করতে পারি?" recommendation — matches budget + time (+ optional category).
     */
    public function recommend(?string $budget, ?string $time, ?string $category, int $limit = 6): array
    {
        return $this->filter([
            'budget' => $budget,
            'time' => $time,
            'category' => $category,
        ], 1, $limit)['data'];
    }

    public function byDay(int $day, int $limit = 20): array
    {
        return $this->all(['status' => 'active', 'navadurga_day' => $day], 'title_bn ASC', $limit);
    }

    public function noCostTimeOnly(int $limit = 8): array
    {
        return $this->query(
            "SELECT * FROM sevas WHERE status='active' AND (estimated_cost_min IS NULL OR estimated_cost_min = 0) ORDER BY title_bn ASC LIMIT {$limit}"
        );
    }
}
