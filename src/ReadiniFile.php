<?php

namespace WriteiniFile;

/**
 * Class ReadiniFile.
 */
class ReadiniFile
{
    /**
     * @var string $path_to_ini_file
     */
    protected static $path_to_ini_file;

    /**
     * @var array $data_ini_file
     */
    protected static $data_ini_file;

    /**
    * method for parsing data in ini file
    * This is a much better solution than the limited abilities of php's ini parser
    * In the php native function if you have ; in your value, it gets truncated.
    * Systems already in use cannot simple escape the data before saving it.
    * PHP does not follow the guidlines for ini values which including allowing ; in the value
    * This function remedies this issue.
    *
    * @param string $filepath     path of ini file
    *
    * @return array ini file data in a array
    */
    public static function better_parse_ini ( $filepath ) {
        $ini = file( $filepath );
        if ( $ini == false ) { return array(); }
        if ( count( $ini ) == 0 ) { return array(); }
        $sections = array();
        $values = array();
        $globals = array();
        $i = 0;
        foreach( $ini as $line ){
            $line = trim( $line );
            // Comments
            if ( $line == '' || $line[0] == ';' ) { continue; }
            // Sections
            if ( $line[0] == '[' ) {
                $sections[] = substr( $line, 1, -1 );
                $i++;
                continue;
            }
            // Key-value pair
            list( $key, $value ) = explode( '=', $line, 2 );
            $key = trim( $key );
            $value = trim( $value );
            if ( $i == 0 ) {
                // Array values
                if ( substr( $line, -1, 2 ) == '[]' ) {
                    $globals[ $key ][] = $value;
                } else {
                    $globals[ $key ] = $value;
                }
            } else {
                // Array values
                if ( substr( $line, -1, 2 ) == '[]' ) {
                    $values[ $i - 1 ][ $key ][] = $value;
                } else {
                    $values[ $i - 1 ][ $key ] = $value;
                }
            }
        }
        for( $j=0; $j<$i; $j++ ) {
            $result[ $sections[ $j ] ] = $values[ $j ];
        }
        return $result + $globals;
    }
    
    
    /**
     * method for get data of ini file.
     *
     * @param string $ini_file     path of ini file
     *
     * @return array ini file data in a array
     */
    public static function get($ini_file)
    {
        self::$path_to_ini_file = $ini_file;

        if (file_exists(self::$path_to_ini_file) === true) {
            self::$data_ini_file = self::better_parse_ini(self::$path_to_ini_file);
        } else {
            throw new \Exception(sprintf('File ini does not exist: %s', self::$path_to_ini_file));
        }

        if (self::$data_ini_file === false) {
            throw new \Exception(sprintf('Unable to parse file ini: %s', self::$path_to_ini_file));
        }

        return self::$data_ini_file;
    }
}
