<?php
/**
 * Validation class
 * Provides the validation functionality
 */

declare(strict_types=1);

namespace App;

use App\Database\Database;

class Validation
{
    const RULE_REQUIRED = 'required';
    const RULE_EMAIL = 'email';
    const RULE_MIN = 'min';
    const RULE_MAX = 'max';
    const RULE_MATCH = 'match';
    const RULE_UNIQUE = 'unique';
    private array $errors = [];

    /**
     * Validate the given values against the validation rules
     * @param array $validationRules
     * @param array $values
     * @return bool
     */
    public function validate(array $validationRules, array $values): bool
    {
        foreach ($validationRules as $field => $rules) {
            $value = $values[$field] ?? null;
            foreach ($rules as $rule) {
                $ruleName = $rule;
                if (!is_string($ruleName)) {
                    $ruleName = $rule[0];
                }
                if ($ruleName === self::RULE_REQUIRED && !$value) {
                    $this->addErrorByRule($field, self::RULE_REQUIRED);
                }
                if ($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addErrorByRule($field, self::RULE_EMAIL);
                }
                if ($ruleName === self::RULE_MIN && strlen($value) < $rule['min']) {
                    $this->addErrorByRule($field, self::RULE_MIN, ['min' => $rule['min']]);
                }
                if ($ruleName === self::RULE_MAX && strlen($value) > $rule['max']) {
                    $this->addErrorByRule($field, self::RULE_MAX);
                }
                if ($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}) {
                    $this->addErrorByRule($field, self::RULE_MATCH, ['match' => $rule['match']]);
                }
                if ($ruleName === self::RULE_UNIQUE) {
                    $uniqueAttr = $rule['attribute'] ?? $field;
                    $className = $rule['class'];
                    $record = (new Database())->getEntityManager()->getRepository($className)->findBy([$uniqueAttr => $value]);

                    if ($record) {
                        $this->addErrorByRule($field, self::RULE_UNIQUE);
                    }
                }
            }
        }
        return empty($this->errors);
    }

    /**
     * Get the validation errors
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Add an error to the errors array
     * @param string $field
     * @param string $message
     */
    public function addError(string $field, string $message): void
    {
        $this->errors[$field][] = $message;
    }

    /**
     * Add an error to the errors array by rule
     * @param string $field
     * @param string $rule
     * @param array $params
     */
    protected function addErrorByRule(string $field, string $rule, array $params = []): void
    {
        $params['field'] ??= $field;
        $errorMessage = self::errorMessage($rule);
        foreach ($params as $key => $value) {
            $errorMessage = str_replace("{{$key}}", $value, $errorMessage);
        }
        $this->errors[$field][] = $errorMessage;
    }

    /**
     * Get the error messages
     * @return array
     */
    public function errorMessages() : array
    {
        return [
            self::RULE_REQUIRED => 'This field is required',
            self::RULE_EMAIL => 'This field must be valid email address',
            self::RULE_MIN => 'Min length of this field must be {min}',
            self::RULE_MAX => 'Max length of this field must be {max}',
            self::RULE_MATCH => 'This field must be the same as {match}',
            self::RULE_UNIQUE => 'Record with with this {field} already exists',
        ];
    }

    /**
     * Get the error message for the given rule
     * @param $rule
     * @return string
     */
    public function errorMessage($rule): string
    {
        return $this->errorMessages()[$rule];
    }

}