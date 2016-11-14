<?php
/**
 * Created by Caro Team (info@carocrm.com).
 * User: Jacky (jacky@carocrm.com).
 * Year: 2016
 * File: CsvHelper.php
 */

namespace Modules\Backend\Helpers;


class CsvHelper
{
    private $fp;
    private $parse_header;
    private $header;
    private $delimiter;
    private $length;

    public function __construct($file_name, $parse_header = false, $delimiter = "\t", $length = 8000)
    {
        $this->fp = fopen($file_name, "r");
        $this->parse_header = $parse_header;
        $this->delimiter = $delimiter;
        $this->length = $length;

        if ($this->parse_header) {
            $this->header = fgetcsv($this->fp, $this->length, $this->delimiter);
        }
    }

    public function __destruct()
    {
        if ($this->fp) {
            fclose($this->fp);
        }
    }
    
    public function getHeader()
    {
        return $this->header;
    }

    public function get($max_lines = 0, $change_header = array())
    {
        //if $max_lines is set to 0, then get all the data

        $data = array();

        if ($max_lines > 0) {
            $line_count = 0;
        } else {
            $line_count = -1; // so loop limit is ignored
        }

        if (is_array($change_header) && $this->parse_header) {
            foreach ($this->header as $i => $heading_i) {
                foreach ($change_header as $key => $key_change) {
                    if ($key == $heading_i) {
                        if ($key_change) {
                            $this->header[$i] = $key_change;   
                        }
                        break;
                    }
                }
            }
        }

        while ($line_count < $max_lines && ($row = fgetcsv($this->fp, $this->length, $this->delimiter)) !== FALSE) {
            if ($this->parse_header) {
                foreach ($this->header as $i => $heading_i) {
                    $row_new[$heading_i] = $row[$i];
                }
                $data[] = $row_new;
            } else {
                $data[] = $row;
            }

            if ($max_lines > 0) {
                $line_count++;
            }
        }
        
        return $data;
    }
}