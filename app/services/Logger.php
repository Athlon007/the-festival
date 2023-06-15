<?php

/**
 * Logger class.
 * Put it in the catch block of every try-catch statement you want to log.
 * @author Konrad
 */
class Logger
{
    const LOG_FOLDER = "../logs/";

    /**
     * Writes a throwable to a log file.
     * @param Throwable $t Throwable to write to log file.
     */
    public static function write(Throwable $t)
    {
        // Create directory, if it does not exist.
        if (!file_exists(self::LOG_FOLDER)) {
            mkdir(self::LOG_FOLDER);
        }

        try {
            // Create file name pattern as follows: yyyy-mm-dd-hh-mm-ss-ms.log
            $date = new DateTime();
            $fileName = $date->format("Y-m-d-H-i-s-u") . ".log";

            // Create file
            $file = fopen(self::LOG_FOLDER . $fileName, "w");

            // Write to file
            fwrite(
                $file,
                $t->getMessage() . " (╯°□°)╯︵ ┻━┻"
                    . "\n\n" . $t->getFile() . ":" . $t->getLine()
                    . "\n\n" . $t->getTraceAsString()
            );

            // Close file
            fclose($file);
        } catch (Throwable $t) {
            // Well damn.
        }
    }
}
