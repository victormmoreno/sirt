<?php
namespace App\Enums;

use Exception;
use ReflectionClass;

class DescargaArchivos extends Enum {
        const INICIO = 'inicio';
        const COMPROMISO = 'compromiso';
        const CIERRE = 'cierre';
        const MANUAL_INF = 'manual_infraestructura';
}

$inicio = DescargaArchivos::INICIO;
$compromiso = DescargaArchivos::COMPROMISO;
$cierre = DescargaArchivos::CIERRE;
$manual = DescargaArchivos::MANUAL_INF;

abstract class Enum
{
    // make sure there are never any instances created
    final private function __construct()
    {
        throw new Exception( 'Enum and Subclasses cannot be instantiated.' );
    }

    /**
     * Give the integer associated with the const of the given string in the format of "class:const"
     *
     * @param string $string
     * @return integer
     */
    final public static function FromString( $string )
    {
        if ( strpos( $string, '::' ) < 1 )
        {
            throw new Exception( 'Enum::FromString( $string ) Input string is not in the expected format.' );
        }
        list( $class, $const ) = explode( '::', $string );

        if ( class_exists( $class, false ) )
        {
            $reflector = new ReflectionClass( $class );
            if ( $reflector->IsSubClassOf( 'Enum' ) )
            {
                if ( $reflector->hasConstant( $const ) )
                {
                    return eval( sprintf( 'return %s;', $string ) );
                }
            }
        }
        throw new Exception( sprintf( '%s does not map to an Enum field', $string ) );
    }

    final public static function IsValidValue( $enumType, $enumValue )
    {
        if ( class_exists( $enumType ) )
        {
            $reflector = new ReflectionClass( $enumType );
            if ( $reflector->IsSubClassOf( 'Enum' ) )
            {
                foreach( $reflector->getConstants() as $label => $value )
                {
                    if ( $value == $enumValue )
                    {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    final public static function IsValidLabel( $enumType, $enumValue )
    {
        if ( class_exists( $enumType ) )
        {
            $reflector = new ReflectionClass( $enumType );
            if ( $reflector->IsSubClassOf( 'Enum' ) )
            {
                foreach( $reflector->getConstants() as $label => $value )
                {
                    if ( $label == $enumValue )
                    {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    /**
     * For a given $enumType, give the complete string representation for the given $enumValue (class::const)
     *
     * @param string $enumType
     * @param integer $enumValue
     * @return string
     */
    final public static function ToString( $enumType, $enumValue )
    {
        $result = 'NotAnEnum::IllegalValue';

        if ( class_exists( $enumType, false ) )
        {
            $reflector = new ReflectionClass( $enumType );
            $result = $reflector->getName() . '::IllegalValue';
            foreach( $reflector->getConstants() as $key => $val )
            {
                if ( $val == $enumValue )
                {
                    $result = str_replace( 'IllegalValue', $key, $result );
                    break;
                }
            }
        }
        return $result;
    }

    /**
     * For a given $enumType, give the label associated with the given $enumValue (const name in class definition)
     *
     * @param string $enumType
     * @param integer $enumValue
     * @return string
     */
    final public static function Label( $enumType, $enumValue )
    {
        $result = 'IllegalValue';

        if ( class_exists( $enumType, false ) )
        {
            $reflector = new ReflectionClass( $enumType );

            foreach( $reflector->getConstants() as $key => $val )
            {
                if ( $val == $enumValue )
                {
                    $result = $key;
                    break;
                }
            }
        }
        return $result;
    }
}
?>