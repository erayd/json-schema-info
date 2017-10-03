<?php

namespace JsonSchemaInfo;

/**
 * Provide info on various json-schema specification standards
 *
 * @package baacode/json-schema-info
 * @license ISC
 * @author Steve Gilberd <steve@erayd.net>
 * @copyright (c) 2017 Erayd LTD
 */
class SchemaInfo
{
    // spec URIs
    const SPEC_DRAFT_03_URI                     =  'http://json-schema.org/draft-03/schema#';
    const SPEC_DRAFT_04_URI                     =  'http://json-schema.org/draft-04/schema#';
    const SPEC_DRAFT_06_URI                     =  'http://json-schema.org/draft-06/schema#';

    // internal spec identifiers

    const SPEC_DRAFT_03                         =  'draft-03';
    // d03 (combined) https://tools.ietf.org/html/draft-zyp-json-schema-03

    const SPEC_DRAFT_04                         =  'draft-04';
    // d04c (core) https://tools.ietf.org/html/draft-zyp-json-schema-04
    // d04v (validation) https://tools.ietf.org/html/draft-fge-json-schema-validation-00
    // d04h (hyper-schema) https://tools.ietf.org/html/draft-luff-json-hyper-schema-00

    const SPEC_DRAFT_06                         =  'draft-06';
    // d06c (core) https://tools.ietf.org/html/draft-wright-json-schema-01
    // d06v (validation) https://tools.ietf.org/html/draft-wright-json-schema-validation-01
    // d06h (hyper-schema) https://tools.ietf.org/html/draft-wright-json-schema-hyperschema-01

    /** @var int Spec version */
    protected $specVersion = null;

    /** @var \StdClass Base spec rules */
    protected $baseInfo = null;

    /** @var \StdClass Spec rules */
    protected $specInfo = null;

    /** @var \StdClass Ruleset schema */
    protected $rulesetSchema = null;

    /** @var \StdClass Spec schema */
    protected $specSchema = null;

    /**
     * Create a new SchemaInfo instance for the provided spec
     *
     * @api
     *
     * @param mixed $spec URI string or spec int constant
     */
    public function __construct($spec)
    {
        // check type
        if (!is_string($spec)) {
            throw new \InvalidArgumentException('Spec must be a string');
        }

        // catch errors
        set_error_handler(function ($errno, $errstr) {
            throw new \RuntimeException("Error loading spec: $errstr"); // @codeCoverageIgnore
        });

        try {
            // translate URI
            $spec = self::getSpecName($spec) ?: $spec;

            // make sure spec is valid
            if (!in_array($spec, array(
                self::SPEC_DRAFT_03,
                self::SPEC_DRAFT_04,
                self::SPEC_DRAFT_06,
            ))) {
                throw new \InvalidArgumentException('Unknown schema spec');
            }

            // load base ruleset file
            $this->baseInfo = json_decode(file_get_contents(__DIR__ . "/../rules/base.json"));
            if (json_last_error() !== \JSON_ERROR_NONE) {
                throw new \RuntimeException('Unable to decode base ruleset file'); // @codeCoverageIgnore
            }

            // load the spec ruleset file
            $this->specInfo = json_decode(file_get_contents(__DIR__ . "/../rules/standard/$spec.json"));
            if (json_last_error() !== \JSON_ERROR_NONE) {
                throw new \RuntimeException('Unable to decode ruleset file'); // @codeCoverageIgnore
            }

            // load the ruleset schema file
            $this->rulesetSchema = json_decode(file_get_contents(__DIR__ . "/../rules/schema.json"));
            if (json_last_error() !== \JSON_ERROR_NONE) {
                throw new \RuntimeException('Unable to decode ruleset schema file'); // @codeCoverageIgnore
            }

            // load the spec schema file
            $this->specSchema = json_decode(file_get_contents(__DIR__ . "/../dist/$spec/schema.json"));
            if (json_last_error() !== \JSON_ERROR_NONE) {
                throw new \RuntimeException('Unable to decode ruleset schema file'); // @codeCoverageIgnore
            }

            $this->specVersion = $spec;
        } catch (\Exception $e) {
            restore_error_handler();
            throw $e;
        }
        restore_error_handler();
    }

    /**
     * Get a rule vocabulary
     *
     * @param string $vocabulary
     * @return Vocabulary
     */
    public function __get($vocabulary)
    {
        if ($vocabulary == 'keyword' || array_key_exists($vocabulary, $this->specInfo->vocabularies)) {
            return $this->$vocabulary = new Vocabulary($this, $vocabulary);
        } else {
            return $this->$vocabulary = null;
        }
    }

    /**
     * Get the spec ruleset definition
     *
     * @return \StdClass
     */
    public function getSpecInfo()
    {
        return $this->specInfo;
    }

    /**
     * Get the base ruleset definition
     *
     * @return \StdClass
     */
    public function getBaseInfo()
    {
        return $this->baseInfo;
    }

    /**
     * Get the spec meta-schema for validation
     *
     * @api
     *
     * @return \StdClass
     */
    public function getSchema()
    {
        return $this->specSchema;
    }

    /**
     * Get the ruleset schema
     *
     * @return \StdClass
     */
    public function getRuleSchema()
    {
        return $this->rulesetSchema;
    }

    /**
     * Get the spec meta-schema URI
     *
     * @api
     *
     * @return string
     */
    public function getURI()
    {
        switch ($this->specVersion) {
            case self::SPEC_DRAFT_06:
                return self::SPEC_DRAFT_06_URI;
            case self::SPEC_DRAFT_04:
                return self::SPEC_DRAFT_04_URI;
            case self::SPEC_DRAFT_03:
                return self::SPEC_DRAFT_03_URI;
        }
    } // @codeCoverageIgnore

    /**
     * Get the spec name for a meta-schema URI
     *
     * @api
     *
     * @param string $uri
     * @return string
     */
    public static function getSpecName($uri)
    {
        // check type
        if (!is_string($uri)) {
            throw new \InvalidArgumentException('URI must be a string');
        }

        // translate URI
        $matches = array();
        if (preg_match('~^https?://json-schema.org/(draft-0[346])/schema($|#.*)~ui', $uri, $matches)) {
            switch ($matches[1]) {
                case 'draft-06':
                    return self::SPEC_DRAFT_06;
                case 'draft-04':
                    return self::SPEC_DRAFT_04;
                case 'draft-03':
                    return self::SPEC_DRAFT_03;
            }
        }

        // no match found
        return null;
    }

    /**
     * Check whether the provided JSON pointer target is a schema
     *
     * @param string $pointer
     * @return bool
     */
    public function pointerTargetIsSchema($pointer)
    {
        // shortcut for pointers to schema root
        if (in_array($pointer, array('#', '#/'))) {
            return true;
        }

        // check pointer is valid
        if (substr($pointer, 0, 2) != '#/') {
            throw new \RuntimeException("Not a JSON pointer: $pointer");
        }

        // decode path
        $path = array_map(function ($element) {
            return strtr($element, array('~1' => '/', '~0' => '~'));
        }, explode('/', substr($pointer, 2)));

        // schema root cannot be an array and numeric properties are not valid keywords
        if (is_numeric($path[0]) && $path[0] == floor($path[0])) {
            return false;
        }

        // iterate path
        $inContainer = false;
        foreach ($path as $element) {
            // ignore integer elements
            if (is_numeric($element) && $element == floor($element)) {
                continue;
            }

            // anything is allowed in the root of a container
            if ($inContainer) {
                $inContainer = false;
                continue;
            }

            // check keyword exists
            if (is_null($keyword = $this->keyword->$element)) {
                return false;
            }

            // check whether keyword may contain a schema
            if ($keyword->{'as-container'}) {
                $inContainer = true;
                continue;
            } elseif (!$keyword->{'as-schema'}) {
                return false;
            }
        }

        // check that terminal element is not a container
        $element = end($path);
        if (!is_null($this->keyword->$element) && $this->keyword->$element->{'as-container'}) {
            return false;
        }

        // provided the target type is correct, it may be treated as a schema
        return true;
    }
}
