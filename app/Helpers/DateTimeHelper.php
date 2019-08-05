<?php

class DateTimeHelper{

    /**
     * Get default TimeZone
     *
     * @return \DateTimeZone
     */
    public static function timezone()
    {
        return new \DateTimeZone("Asia/Ho_Chi_Minh");
    }

    /**
     * Get Current DateTime
     *
     * @return \DateTime
     */
    public static function now()
    {
        return new \DateTime('now', static::timezone());
    }

}
