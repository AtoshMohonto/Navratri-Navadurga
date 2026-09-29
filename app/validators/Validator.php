<?php

namespace App\Validators;

use App\Core\Database;

class Validator
{
    protected array $data;
    protected array $errors = [];

    protected array $messages = [
        'required' => '%s আবশ্যক।',
        'email' => 'সঠিক ইমেইল ঠিকানা দিন।',
        'min' => '%s কমপক্ষে %s অক্ষরের হতে হবে।',
        'max' => '%s সর্বোচ্চ %s অক্ষরের হতে পারবে।',
        'same' => '%s মিলছে না।',
        'unique' => 'এই %s আগে থেকেই ব্যবহৃত হয়েছে।',
        'numeric' => '%s অবশ্যই সংখ্যা হতে হবে।',
        'in' => '%s এর মান সঠিক নয়।',
    ];

    protected array $labels = [];

    public function __construct(array $data, array $labels = [])
    {
        $this->data = $data;
        $this->labels = $labels;
    }

    public static function make(array $data, array $rules, array $labels = []): self
    {
        $validator = new self($data, $labels);
        $validator->run($rules);
        return $validator;
    }

    protected function label(string $field): string
    {
        return $this->labels[$field] ?? $field;
    }

    protected function run(array $rules): void
    {
        foreach ($rules as $field => $ruleString) {
            $value = $this->data[$field] ?? null;
            $rulesList = explode('|', $ruleString);

            foreach ($rulesList as $rule) {
                $params = [];
                if (str_contains($rule, ':')) {
                    [$rule, $paramStr] = explode(':', $rule, 2);
                    $params = explode(',', $paramStr);
                }

                $this->applyRule($field, $value, $rule, $params);
            }
        }
    }

    protected function applyRule(string $field, $value, string $rule, array $params): void
    {
        $label = $this->label($field);

        switch ($rule) {
            case 'required':
                if ($value === null || trim((string) $value) === '') {
                    $this->addError($field, sprintf($this->messages['required'], $label));
                }
                break;
            case 'email':
                if ($value && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($field, $this->messages['email']);
                }
                break;
            case 'min':
                if ($value !== null && mb_strlen((string) $value) < (int) $params[0]) {
                    $this->addError($field, sprintf($this->messages['min'], $label, $params[0]));
                }
                break;
            case 'max':
                if ($value !== null && mb_strlen((string) $value) > (int) $params[0]) {
                    $this->addError($field, sprintf($this->messages['max'], $label, $params[0]));
                }
                break;
            case 'same':
                if (($this->data[$params[0]] ?? null) !== $value) {
                    $this->addError($field, sprintf($this->messages['same'], $label));
                }
                break;
            case 'numeric':
                if ($value !== null && $value !== '' && !is_numeric($value)) {
                    $this->addError($field, sprintf($this->messages['numeric'], $label));
                }
                break;
            case 'in':
                if ($value !== null && $value !== '' && !in_array($value, $params, true)) {
                    $this->addError($field, sprintf($this->messages['in'], $label));
                }
                break;
            case 'unique':
                [$table, $column] = [$params[0], $params[1] ?? $field];
                $exceptId = $params[2] ?? null;
                if ($value !== null && $value !== '' && $this->existsInTable($table, $column, $value, $exceptId)) {
                    $this->addError($field, sprintf($this->messages['unique'], $label));
                }
                break;
        }
    }

    protected function existsInTable(string $table, string $column, $value, ?string $exceptId): bool
    {
        $sql = "SELECT COUNT(*) AS c FROM {$table} WHERE {$column} = :value";
        $params = ['value' => $value];

        if ($exceptId) {
            $sql .= " AND id != :except_id";
            $params['except_id'] = $exceptId;
        }

        $stmt = Database::connection()->prepare($sql);
        $stmt->execute($params);
        return (int) $stmt->fetch()['c'] > 0;
    }

    protected function addError(string $field, string $message): void
    {
        $this->errors[$field][] = $message;
    }

    public function fails(): bool
    {
        return !empty($this->errors);
    }

    public function passes(): bool
    {
        return empty($this->errors);
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function firstError(): ?string
    {
        foreach ($this->errors as $fieldErrors) {
            return $fieldErrors[0];
        }
        return null;
    }
}
