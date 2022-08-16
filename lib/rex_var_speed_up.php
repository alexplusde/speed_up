<?php
/**
 *     REX_SPEED_UP[]
 */
class rex_var_speed_up extends rex_var
{
    protected function getOutput()
    {
        $speed_up = new speed_up();

        return self::quote($speed_up->getOutput());
    }
}
