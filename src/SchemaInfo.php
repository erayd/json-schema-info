<?php

namespace Erayd\JsonSchemaInfo;

/**
 * Provide info on various json-schema specification standards
 *
 * @package json-schema-info
 * @license ISC
 * @author Steve Gilberd <steve@erayd.net>
 */
class SchemaInfo
{
    // internal spec identifiers
    const SPEC_NONE                             = 0;

    const SPEC_DRAFT_03                         = 1;
    // d03 (combined) https://tools.ietf.org/html/draft-zyp-json-schema-03

    const SPEC_DRAFT_04                         = 2;
    // d04c (core) https://tools.ietf.org/html/draft-zyp-json-schema-04
    // d04v (validation) https://tools.ietf.org/html/draft-fge-json-schema-validation-00
    // d04h (hyper-schema) https://tools.ietf.org/html/draft-luff-json-hyper-schema-00

    const SPEC_DRAFT_05                         = 3;
    // d05c (core) https://tools.ietf.org/html/draft-wright-json-schema-00
    // d05v (validation) https://tools.ietf.org/html/draft-wright-json-schema-validation-00
    // d05h (hyper-schema) https://tools.ietf.org/html/draft-wright-json-schema-hyperschema-00

    // spec URIs
    const SPEC_DRAFT_03_URI                     = 'http://json-schema.org/draft-03/schema#';
    const SPEC_DRAFT_04_URI                     = 'http://json-schema.org/draft-04/schema#';
    const SPEC_DRAFT_05_URI                     = 'http://json-schema.org/draft-05/schema#';

    // primitive types
    const OPT_TYPE_STRING                       = true;  // primitive type string is allowed (d03§5.1, d04c§3.5, d05c§4.2)
    const OPT_TYPE_NUMBER                       = true;  // primitive type number is allowed (d03§5.1, d04c§3.5, d05c§4.2)
    const OPT_TYPE_INTEGER                      = false; // primitive type integer is allowed (d03§5.1, d04c§3.5, !d05)
    const OPT_TYPE_BOOLEAN                      = true;  // primitive type boolean is allowed (d03§5.1, d04c§3.5, d05c§4.2)
    const OPT_TYPE_OBJECT                       = true;  // primitive type object is allowed (d03§5.1, d04c§3.5, d05c§4.2)
    const OPT_TYPE_ARRAY                        = true;  // primitive type array is allowed (d03§5.1, d04c§3.5, d05c§4.2)
    const OPT_TYPE_NULL                         = true;  // primitive type null is allowed (d03§5.1, d04c§3.5, d05c§4.2)
    const OPT_TYPE_ANY                          = false; // primitive type any is allowed (d03§5.1, !d04, !d05)
    const OPT_TYPE_OTHER                        = false; // other, non-spec primitive types are allowed (d03§5.1, !d04, !d05)

    // basic properties
    const OPT_SELF_DESCRIPTIVE_SCHEMA           = false; // Whether $schema must validate against itself (draft-04 §6.1)

    // numeric constraints
    const OPT_CONSTRAINT_DIVISIBLE_BY           = false; // Whether "divisibleBy" is supported (d03§5.24)
    const OPT_CONSTRAINT_MULTIPLE_OF            = true;  // Whether "multipleOf" is supported (d04v§5.1.1, d05v§5.1)
    const OPT_CONSTRAINT_MAXIMUM                = true;  // Whether "maxumum" is supported (d03§5.10, d04v§5.1.2, d05v§5.2)
    const OPT_CONSTRAINT_EXCLUSIVE_MAXUMUM      = true;  // Whether "exclusiveMaximum" is supported (d03§5.12, d04v§5.1.2, d05v§5.3)
    const OPT_CONSTRAINT_MINIMUM                = true;  // Whether "minimum" is supported (d03§5.9, d04v§5.1.3, d05v§5.4)
    const OPT_CONSTRAINT_EXCLUSIVE_MINIMUM      = true;  // Whether "exclusiveMinimum" is supported (d03§5.11, d04v§5.1.3, d05v§5.5)

    // string constraints
    const OPT_CONSTRAINT_MIN_LENGTH             = true;  // Whether "minLength" is supported (d03§5.17, d04v§5.2.2, d05v§5.7)
    const OPT_CONSTRAINT_MAX_LENGTH             = true;  // Whether "maxLength" is supported (d03§5.18, d04v§5.2.1, d05v§5.6)
    const OPT_CONSTRAINT_PATTERN                = true;  // Whether "pattern" is supported (d03§5.16, d04v§5.2.3, d05v§5.8)

    // array constraints
    const OPT_CONSTRAINT_ITEMS                  = true;  // Whether "items" is supported (d03§5.5, d04v§5.3.1, d05v§5.9)
    const OPT_CONSTRAINT_ADDITIONAL_ITEMS       = true;  // Whether "additionalItems" is supported (d03§5.6, d04v§5.3.1, d05v§5.9)
    const OPT_CONSTRAINT_MAX_ITEMS              = true;  // Whether "maxItems" is supported (d03§5.14, d04v§5.3.2, d05v§5.10)
    const OPT_CONSTRAINT_MIN_ITEMS              = true;  // Whether "minItems" is supported (d03§5.13, d04v§5.3.3, d05v§5.11)
    const OPT_CONSTRAINT_UNIQUE_ITEMS           = true;  // Whether "uniqueItems" is supported (d03§5.15, d04v§5.3.4, d05v§5.12)

    // object constraints
    const OPT_CONSTRAINT_MAX_PROPERTIES         = true;  // Whether "maxProperties" is supported (!d03, d04v§5.4.1, d04v§5.13)
    const OPT_CONSTRAINT_MIN_PROPERTIES         = true;  // Whether "minProperties" is supported (!d03, d04v§5.4.2, d05v§5.14)
    const OPT_CONSTRAINT_REQUIRED               = true;  // Whether "required" is supported (d03§5.7, d04v§5.4.3, d05v§5.15)
    const OPT_CONSTRAINT_REQUIRED_BOOLEAN       = false; // Whether "required" is a boolean (d03§5.7, d04v§5.4.3.1, d05v§5.15)
    const OPT_CONSTRAINT_REQUIRED_ARRAY         = true;  // Whether "required" is an array (d03§5.7, d04v§5.4.3.1, d05v§5.15)
    const OPT_CONSTRAINT_PROPERTIES             = true;  // Whether "properties" is supported (d03§5.2, d04v§5.4.4, d05v§5.16)
    const OPT_CONSTRAINT_PATTERN_PROPERTIES     = true;  // Whether "patternProperties" is supported (d03§5.3, d04v§5.4.4, d05v§5.17)
    const OPT_CONSTRAINT_ADDITIONAL_PROPERTIES  = true;  // Whether "additionalProperties" is supported (d03§5.4, d04v§5.4.4, d05v§5.18)
    const OPT_CONSTRAINT_DEPENDENCIES           = true;  // Whether "dependencies" is supported (d03§5.8, d04v§5.4.5, d05v§5.19)
    const OPT_CONSTRAINT_DEPENDENCIES_SIMPLE    = false; // Whether "dependencies" may directly list a string property, or an array of
                                                         //     string properties (d03§5.8, d04v§5.4.5.1, d05v§5.19)

    /** @var int Spec version **/
    protected $specVersion = self::SPEC_NONE;

    /** @var array Feature matrix */
    protected $matrix = array();

    /**
     * @param mixed $spec URI string or spec int constant
     */
    public function __construct($spec)
    {
        // make sure spec is an int
        if (!is_int($spec)) {
            $spec = self::getSpecForURI($spec);
        }

        // spec-specific setup
        switch ($spec) {
            case self::SPEC_DRAFT_05:
                $this->setDraft05();
                break;
            case self::SPEC_DRAFT_04:
                $this->setDraft04();
                break;
            case self::SPEC_DRAFT_03:
                $this->setDraft03();
                break;
            default:
                throw new \InvalidArgumentException('Unknown schema spec');
        }
    }

    /**
     * Get the status of an option
     */
    public function __get($optionName)
    {
        $defaultValue = null;
        $option = self::getOptionConstant($optionName, $defaultValue);

        if (!array_key_exists($option, $this->matrix)) {
            $this->matrix[$option] = $defaultValue;
        }

        return $this->matrix[$option];
    }

    /**
     * Get the spec version by URI
     *
     * @param string $uri
     * @return int
     */
    public static function getSpecForURI($uri)
    {
        if (!is_string($uri) || !strlen($uri)) {
            throw new \InvalidArgumentException('You must provide a URI');
        }

        $matches = array();
        if (preg_match('~^https?://json-schema.org/(draft-[0-9]+)/schema($|#.*)~ui', $uri, $matches)) {
            switch ($matches[1]) {
                case 'draft-05':
                    return self::SPEC_DRAFT_05;
                case 'draft-04':
                    return self::SPEC_DRAFT_04;
                case 'draft-03':
                    return self::SPEC_DRAFT_03;
            }
        }

        throw new \InvalidArgumentException("Unknown schema spec: $uri");
    }

    /**
     * Get the constant name for a given camelCase option
     *
     * @param string $option Option name (camelCase or CONSTANT_CASE)
     * @return string
     */
    public static function getOptionConstant($optionName, &$defaultValue = null)
    {
        $words = preg_split('/(?<=[a-z0-9])(?=[A-Z])|(?<=[A-Z])(?=[A-Z][a-z0-9])/', $optionName);
        array_walk($words, function (&$item) {
            $item = strtoupper($item);
        });
        $optionConst = 'OPT_' . implode('_', $words);

        if (!defined('\Erayd\JsonSchemaInfo\SchemaInfo::' . $optionConst)) {
            throw new \InvalidArgumentException("No option constant $optionConst available for $optionName");
        }

        $defaultValue = constant('\Erayd\JsonSchemaInfo\SchemaInfo::' . $optionConst);

        return $optionConst;
    }

    /**
     * Set options
     * @param array $options Options to set
     */
    private function setOptions($options)
    {
        foreach ($options as $option => $value) {
            $this->matrix[$option] = $value;
        }
    }

    /**
     * Apply options that are unique to draft-03
     */
    protected function setDraft03()
    {
        $this->setOptions(array(
            'OPT_TYPE_INTEGER'                      => true,  // d03§5.1
            'OPT_TYPE_ANY'                          => true,  // d03§5.1
            'OPT_TYPE_OTHER'                        => true,  // d03§5.1
            'OPT_CONSTRAINT_DIVISIBLE_BY'           => true,  // d03§5.24 (renamed to "multipleOf" in draft-04)
            'OPT_CONSTRAINT_MULTIPLE_OF'            => false, // not present in draft-03, draft-03 implements as "divisibleBy" (§5.24)
            'OPT_CONSTRAINT_MAX_PROPERTIES'         => false, // not present in draft-03
            'OPT_CONSTRAINT_MIN_PROPERTIES'         => false, // not present in draft-03
            'OPT_CONSTRAINT_REQUIRED_BOOLEAN'       => true,  // d03§5.7 (changes from string to array in draft-04)
            'OPT_CONSTRAINT_REQUIRED_ARRAY'         => false, // d03§5.7 (changes from string to array in draft-04)
            'OPT_CONSTRAINT_DEPENDENCIES_SIMPLE'    => true,  // d03§5.8
        ));
    }

    /**
     * Apply options that are unique to draft-04
     */
    protected function setDraft04()
    {
        $this->setOptions(array(
            'OPT_TYPE_INTEGER'              => true,  // d04c§3.5
            'OPT_SELF_DESCRIPTIVE_SCHEMA'   => true,  // d04c§6.1
        ));
    }

    /**
     * Apply options that are unique to draft-05
     */
    protected function setDraft05()
    {
        $this->setOptions(array(

        ));
    }
}
