<?php
if (! function_exists('avatar')) {
    /**
     * Avatar do User
     *
     * @param DateTime $user
     * @param string   $class
     *
     * @return string
     */
    function avatar($user, $class = 'img-circle')
    {
        $avatar = asset('assets/img/avatar.jpg');

        if ($user instanceof \NwManager\Entities\User) {
            $avatar = asset('assets/img/a'.$user->id.'.jpg');
        }

        return sprintf('<img class="%s" src="%s" />', $class, $avatar);
    }
}

if (! function_exists('projectLabelStatus')) {
    function projectLabelStatus($project)
    {
        switch ($project->status) {
            case $project::STATUS_ATIVO:
                return 'Ativo';

            case $project::STATUS_ENCERRADO:
                return 'Encerrado';

            case $project::STATUS_PAUSADO:
                return 'Pausado';

            default:
                return 'Inativo';
        }
    }
}
    
if (! function_exists('projectClassStatus')) {
    function projectClassStatus($project)
    {
        switch ($project->status) {
            case $project::STATUS_ATIVO:
                return 'primary';

            case $project::STATUS_ENCERRADO:
                return 'danger';

            case $project::STATUS_PAUSADO:
                return 'warning';

            default:
                return 'default';
        }
    }
}

if (! function_exists('dateFormatter')) {
    /**
     * Date Formatter
     *
     * @param DateTime $date
     * @param string   $dateType
     * @param string   $timeType
     *
     * @return string
     */
    function dateFormatter($date, $dateType, $timeType)
    {
        if ($date instanceof \DateTime) {
            $fmt = new \IntlDateFormatter(
                config('app.locale'),
                $dateType,
                $timeType,
                config('app.timezone')
            );

            return $fmt->format($date);
        }

        return $date;
    }
}

if (! function_exists('formatDateTime')) {
    /**
     * Format Date Time
     *
     * @param DateTime $date
     *
     * @return string
     */
    function formatDateTime($date)
    {
        return dateFormatter($date, \IntlDateFormatter::MEDIUM, \IntlDateFormatter::MEDIUM);
    }
}

if (! function_exists('formatDate')) {
    /**
     * Format Date
     *
     * @param DateTime $date
     *
     * @return string
     */
    function formatDate($date)
    {
        return dateFormatter($date, \IntlDateFormatter::MEDIUM, \IntlDateFormatter::NONE);
    }
}

if (! function_exists('formatTime')) {
    /**
     * Format Time
     *
     * @param DateTime $date
     *
     * @return string
     */
    function formatTime($date)
    {
        return dateFormatter($date, \IntlDateFormatter::NONE, \IntlDateFormatter::MEDIUM);
    }
}

if (! function_exists('formatDateLong')) {
    /**
     * Format Date Long
     *
     * @param DateTime $date
     *
     * @return string
     */
    function formatDateLong($date)
    {
        return dateFormatter($date, \IntlDateFormatter::LONG, \IntlDateFormatter::NONE);
    }
}

if (! function_exists('formatDateFull')) {
    /**
     * Format Date Full
     *
     * @param DateTime $date
     *
     * @return string
     */
    function formatDateFull($date)
    {
        return dateFormatter($date, \IntlDateFormatter::FULL, \IntlDateFormatter::NONE);
    }
}

if (! function_exists('formatDateTimeFull')) {
    /**
     * Format Date Time Full
     *
     * @param DateTime $date
     *
     * @return string
     */
    function formatDateTimeFull($date)
    {
        if ($date instanceof \DateTime) {
            return sprintf('%s - %s', 
                dateFormatter($date, \IntlDateFormatter::FULL, \IntlDateFormatter::NONE),
                dateFormatter($date, \IntlDateFormatter::NONE, \IntlDateFormatter::MEDIUM));
        }
    }
}

if (! function_exists('diffForHumans')) {
    /**
     * Diff date for Humans
     *
     * @param \DateTime $date
     *
     * @return string
     */
    function diffForHumans($date)
    {
        if ($date instanceof \DateTime) {
            $date = \Carbon\Carbon::instance($date);
            return $date->diffForHumans();
        }

        return '';
    }
}

if (! function_exists('now')) {
    /**
     * Now Date Time
     *
     * @return Carbon
     */
    function now()
    {
        return Carbon\Carbon::now();
    }
}

if (! function_exists('formatCurrency')) {
    /**
     * Formato moeda conforme locale
     *
     * @param float $valor
     *
     * @return string
     */
    function formatCurrency($valor)
    {
        $fmt = new \NumberFormatter(config('app.locale'), \NumberFormatter::PERCENT);
        return $fmt->format(floatval($valor));
    }
}

if (! function_exists('formatNumber')) {
    /**
     * Formato numero conforme locale
     *
     * @param float $valor
     *
     * @return string
     */
    function formatNumber($valor, $decimais = 2)
    {
        $valor   = floatval($valor);
        $decimais = intval($decimais);

        $pattern = sprintf('#,##0.%s', str_pad('', $decimais, '0'));

        $fmt = new \NumberFormatter(config('app.locale'), \NumberFormatter::DECIMAL);
        $fmt->setPattern($pattern);
        return $fmt->format($valor);
    }
}