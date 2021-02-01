<?php
namespace Orkan;

/**
 * Helper functions
 *
 * @author Orkan
 */
class Utils
{

	/**
	 * Format byte size string
	 * Examples: 361 bytes | 1016.1 kB | 14.62 Mb | 2.81 GB
	 *
	 * @param int $bytes Size in bytes
	 * @return string Byte size string
	 */
	public static function formatBytes( int $bytes = 0 ): string
	{
		$sizes = array( 'bytes', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB' );
		return $bytes ? ( round( $bytes / pow( 1024, ( $i = floor( log( $bytes, 1024 ) ) ) ), $i > 1 ? 2 : 1 ) . ' ' . $sizes[$i] ) : '0 ' . $sizes[0];
	}

	/**
	 * Format time
	 *
	 * @param float $seconds Time in fractional seconds
	 * @param bool $fractions Add fractions part?
	 * @param int $precision How many fractional digits?
	 * @return string Time in format 18394d 16g 11m 41.589s
	 */
	public static function formatTime( float $seconds, bool $fractions = true, int $precision = 3 ): string
	{
		$d = $h = $m = 0;
		$s = (int) $seconds; // truncate fraction
		$u = $fractions ? round( $seconds - $s, $precision ) : 0; // truncate int and round

		if ( $s >= 86400 ) {
			$d = floor( $s / 86400 );
			$s = floor( $s % 86400 );
		}
		if ( $s >= 3600 ) {
			$h = floor( $s / 3600 );
			$s = floor( $s % 3600 );
		}
		if ( $s >= 60 ) {
			$m = floor( $s / 60 );
			$s = floor( $s % 60 );
		}
		$s = $s + $u;
		return trim( ( $d ? "{$d}d " : '' ) . ( $h ? "{$h}g " : '' ) . ( $m ? "{$m}m " : '' ) . "{$s}s" );
	}

	/**
	 * Remove double spaces from PHP::print_r()
	 *
	 * @param array $array
	 * @return string
	 */
	public static function print_r( array $array ): string
	{
		$str = print_r( $array, true );
		return preg_replace( '/[ ]{2,}/', '', $str );
	}

	/**
	 * Print message to standard output or STDERR if in CLI mode
	 * Notes:
	 * STDOUT and echo both seems to work in CLI
	 * STDERR is buffered and displays last
	 *
	 * @codeCoverageIgnore
	 *
	 * @param string $message
	 * @param bool $is_error Choose the right I/O stream for outputing errors
	 * @param string $codepage
	 */
	public static function print( string $message, bool $is_error = false, string $codepage = 'cp852' ): void
	{
		if ( defined( 'TESTING' ) ) {
			$date = \DateTime::createFromFormat( 'U.u', microtime( true ) )->format( 'Y-m-d H:i:s.u' );
			$line = sprintf( '[%s] %s', $date, $message );
			file_put_contents( __DIR__ . '/TESTING-Orkan-Utils-print.log', $line, FILE_APPEND );
			return;
		}

		if ( 'cli' === php_sapi_name() ) {
			fwrite( $is_error ? STDERR : STDOUT, iconv( 'utf-8', $codepage, $message ) );
		} else {
			echo $message;
		}
	}

	/**
	 * Print message to STDERR
	 *
	 * @codeCoverageIgnore
	 *
	 * @param string $message
	 * @param string $codepage
	 */
	public static function stderr( string $message, string $codepage = 'cp852' ): void
	{
		self::print( $message, true, $codepage );
	}

	/**
	 * PHP function to make slug (URL string)
	 * This was based off the one in Symfony's Jobeet tutorial.
	 *
	 * @link https://stackoverflow.com/questions/2955251/php-function-to-make-slug-url-string
	 * @param string $text
	 * @return string
	 */
	public static function slugify( string $text ): string
	{
		// replace non letter or digits by -
		$text = preg_replace( '~[^.\pL\d]+~u', '-', $text );

		// transliterate
		$text = iconv( 'utf-8', 'us-ascii//TRANSLIT', $text );

		// remove unwanted characters
		$text = preg_replace( '~[^-.\w]+~', '', $text );

		// trim
		$text = trim( $text, '-' );

		// remove duplicate -
		$text = preg_replace( '~-+~', '-', $text );

		// lowercase
		$text = strtolower( $text );

		if ( empty( $text ) ) {
			return 'n-a';
		}

		return $text;
	}

	/**
	 * Some fancy implode
	 * Example: 'aaa', 'bbb', 'ccc'
	 *
	 * @param array $arr
	 * @param string $sep
	 * @param string $start
	 * @param string $end
	 * @return string
	 */
	public static function implode( array $arr, string $sep = ', ', string $start = "'", string $end = "'" ): string
	{
		return $start . implode( $end . $sep . $start, $arr ) . $end;
	}

	/**
	 * Compute absolute path from relative at base
	 *
	 * @param string $path Relative path
	 * @param string $base Base dir for $path
	 * @return string
	 */
	public static function pathToAbs( string $path, string $base )
	{
		$old = getcwd();
		chdir( $base );
		$result = realpath( $path );
		chdir( $old );
		return $result;
	}

	/**
	 * Get last key of given array
	 *
	 * @param array $arr
	 * @return mixed
	 */
	public static function lastKey( array &$arr )
	{
		return key( array_slice( $arr, - 1 ) );
	}

	/**
	 * Format two timestamps with timezone
	 * Calculate time diff
	 *
	 * @param int $time Timestamp A
	 * @param int $stop Timestamp B
	 * @param string $zone @link https://www.php.net/manual/en/timezones.php
	 * @param array $format['begin', 'final', 'diff']
	 * @link https://www.php.net/manual/en/datetime.format.php
	 * @link https://www.php.net/manual/en/dateinterval.format.php
	 * @return array Formated dates: Array ( 'begin' => ... , 'final' => ..., 'diff' => ... )
	 */
	public static function formatDateDiff( int $time, int $stop, string $zone, array $format = [] ): array
	{
		$out = [];

		$Tzone = new \DateTimeZone( $zone );
		$begin = ( new \DateTime() )->setTimestamp( $time )->setTimezone( $Tzone );
		$final = ( new \DateTime() )->setTimestamp( $stop )->setTimezone( $Tzone );

		$out['begin'] = $begin->format( $format[0] ?? 'l, d.m.Y H:i');
		$out['final'] = $final->format( $format[1] ?? 'l, d.m.Y H:i');

		if ( ! isset( $format[2] ) || '%a' === $format[2] ) {
			$begin->setTime( 0, 0 ); // Count full days!
			$final->setTime( 0, 0 );
		}

		$out['diff'] = $final->diff( $begin )->format( $format[2] ?? '%a');

		return $out;
	}

	/**
	 * Increment array element
	 */
	public static function keyIncrement( &$arr, $key )
	{
		$arr[$key] = isset( $arr[$key] ) ? $arr[$key] + 1 : 1;
	}

	/**
	 * Collator::sort()
	 *
	 * @param array $arr
	 * @param string $locale
	 */
	public static function sort( array &$arr, string $locale ): void
	{
		$Collator = collator_create( $locale );
		collator_sort( $Collator, $arr );
	}

	/**
	 * Missing Collator::ksort()
	 *
	 * @param array $arr
	 * @param string $locale
	 */
	public static function ksort( array &$arr, string $locale ): void
	{
		$out = [];
		$keys = array_keys( $arr );
		$Collator = collator_create( $locale );
		collator_sort( $Collator, $keys );
		foreach ( $keys as $k ) {
			$out[$k] = $arr[$k];
		}
		$arr = $out;
	}

	/**
	 * Compute execution time
	 *
	 * @param int|float $start Previous time in nanoseconds or leave empty to get new one
	 * @return float Time diff in frac seconds
	 */
	public static function exectime( $start = 0 )
	{
		$time = hrtime( true );

		if ( 0 == $start ) {
			return $time;
		}

		$end = $time - $start;
		$end = $end / 1e+9; // nanoseconds to seconds 0.123456789
		return $end;
	}
}
