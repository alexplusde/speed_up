<?php

/**
 *     REX_SPEED_UP_ASSET[file="file.jpg"] // Datei file.jpg aus dem Assets-Ordner.
 */
class rex_var_speed_up_asset extends rex_var
{
    protected function getOutput()
    {
        if ($this->hasArg('file')) {
            return self::quote(speed_up_asset::getUrl($this->getArg('file')));
        }

        return self::quote('');
    }
}
