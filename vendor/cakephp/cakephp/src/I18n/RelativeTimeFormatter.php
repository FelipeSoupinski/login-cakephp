<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         3.2.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace Cake\I18n;

use Cake\Chronos\ChronosInterface;
use DateTimeInterface;

/**
 * Helper class for formatting relative dates & times.
 *
 * @internal
 */
class RelativeTimeFormatter
{
    /**
     * Get the difference in a human readable format.
     *
     * @param \Cake\Chronos\ChronosInterface $date The datetime to start with.
     * @param \Cake\Chronos\ChronosInterface|null $other The datetime to compare against.
     * @param bool $absolute removes time difference modifiers ago, after, etc
     * @return string The difference between the two days in a human readable format
     * @see \Cake\Chronos\ChronosInterface::diffForHumans
     */
    public function diffForHumans(ChronosInterface $date, ChronosInterface $other = null, $absolute = false)
    {
        $isNow = $other === null;
        if ($isNow) {
            $other = $date->now($date->getTimezone());
        }
        $diffInterval = $date->diff($other);

        switch (true) {
            case ($diffInterval->y > 0):
                $count = $diffInterval->y;
                $message = __dn('cake', '{0} ano', '{0} anos', $count, $count);
                break;
            case ($diffInterval->m > 0):
                $count = $diffInterval->m;
                $message = __dn('cake', '{0} mês', '{0} meses', $count, $count);
                break;
            case ($diffInterval->d > 0):
                $count = $diffInterval->d;
                if ($count >= ChronosInterface::DAYS_PER_WEEK) {
                    $count = (int)($count / ChronosInterface::DAYS_PER_WEEK);
                    $message = __dn('cake', '{0} semana', '{0} semanas', $count, $count);
                } else {
                    $message = __dn('cake', '{0} dia', '{0} dias', $count, $count);
                }
                break;
            case ($diffInterval->h > 0):
                $count = $diffInterval->h;
                $message = __dn('cake', '{0} hora', '{0} horas', $count, $count);
                break;
            case ($diffInterval->i > 0):
                $count = $diffInterval->i;
                $message = __dn('cake', '{0} minuto', '{0} minutos', $count, $count);
                break;
            default:
                $count = $diffInterval->s;
                $message = __dn('cake', '{0} segundo', '{0} segundos', $count, $count);
                break;
        }
        if ($absolute) {
            return $message;
        }
        $isFuture = $diffInterval->invert === 1;
        if ($isNow) {
            return $isFuture ? __d('cake', '{0} a partir de agora', $message) : __d('cake', '{0} atrás', $message);
        }

        return $isFuture ? __d('cake', '{0} depois', $message) : __d('cake', '{0} antes', $message);
    }

    /**
     * Format a into a relative timestring.
     *
     * @param \DateTimeInterface $time The time instance to format.
     * @param array $options Array of options.
     * @return string Relative time string.
     * @see \Cake\I18n\Time::timeAgoInWords()
     */
    public function timeAgoInWords(DateTimeInterface $time, array $options = [])
    {
        $options = $this->_options($options, FrozenTime::class);
        if ($options['timezone'] && $time instanceof ChronosInterface) {
            $time = $time->timezone($options['timezone']);
        }

        $now = $options['from']->format('U');
        $inSeconds = $time->format('U');
        $backwards = ($inSeconds > $now);

        $futureTime = $now;
        $pastTime = $inSeconds;
        if ($backwards) {
            $futureTime = $inSeconds;
            $pastTime = $now;
        }
        $diff = $futureTime - $pastTime;

        if (!$diff) {
            return __d('cake', 'just now', 'just now');
        }

        if ($diff > abs($now - (new FrozenTime($options['end']))->format('U'))) {
            return sprintf($options['absoluteString'], $time->i18nFormat($options['format']));
        }

        $diffData = $this->_diffData($futureTime, $pastTime, $backwards, $options);
        list($fNum, $fWord, $years, $months, $weeks, $days, $hours, $minutes, $seconds) = array_values($diffData);

        $relativeDate = [];
        if ($fNum >= 1 && $years > 0) {
            $relativeDate[] = __dn('cake', '{0} ano', '{0} anos', $years, $years);
        }
        if ($fNum >= 2 && $months > 0) {
            $relativeDate[] = __dn('cake', '{0} mês', '{0} meses', $months, $months);
        }
        if ($fNum >= 3 && $weeks > 0) {
            $relativeDate[] = __dn('cake', '{0} semana', '{0} semanas', $weeks, $weeks);
        }
        if ($fNum >= 4 && $days > 0) {
            $relativeDate[] = __dn('cake', '{0} dia', '{0} dias', $days, $days);
        }
        if ($fNum >= 5 && $hours > 0) {
            $relativeDate[] = __dn('cake', '{0} hora', '{0} horas', $hours, $hours);
        }
        if ($fNum >= 6 && $minutes > 0) {
            $relativeDate[] = __dn('cake', '{0} minuto', '{0} minutos', $minutes, $minutes);
        }
        if ($fNum >= 7 && $seconds > 0) {
            $relativeDate[] = __dn('cake', '{0} segundo', '{0} segundos', $seconds, $seconds);
        }
        $relativeDate = implode(', ', $relativeDate);

        // When time has passed
        if (!$backwards) {
            $aboutAgo = [
                'second' => __d('cake', 'cerca de um segundo atrás'),
                'minute' => __d('cake', 'cerca de um minuto atrás'),
                'hour' => __d('cake', 'cerca de uma hora atrás'),
                'day' => __d('cake', 'cerca de um dia atrás'),
                'week' => __d('cake', 'cerca de uma semana atrás'),
                'month' => __d('cake', 'cerca de um mês atrás'),
                'year' => __d('cake', 'cerca de um ano atrás'),
            ];

            return $relativeDate ? sprintf($options['relativeString'], $relativeDate) : $aboutAgo[$fWord];
        }

        // When time is to come
        if ($relativeDate) {
            return $relativeDate;
        }
        $aboutIn = [
            'second' => __d('cake', 'em cerca de um segundo'),
            'minute' => __d('cake', 'em cerca de um minuto'),
            'hour' => __d('cake', 'em cerca de uma hora'),
            'day' => __d('cake', 'em cerca de um dia'),
            'week' => __d('cake', 'em cerca de uma semana'),
            'month' => __d('cake', 'em cerca de um mês'),
            'year' => __d('cake', 'em cerca de um ano'),
        ];

        return $aboutIn[$fWord];
    }

    /**
     * Calculate the data needed to format a relative difference string.
     *
     * @param int|string $futureTime The timestamp from the future.
     * @param int|string $pastTime The timestamp from the past.
     * @param bool $backwards Whether or not the difference was backwards.
     * @param array $options An array of options.
     * @return array An array of values.
     */
    protected function _diffData($futureTime, $pastTime, $backwards, $options)
    {
        $diff = (int)$futureTime - (int)$pastTime;

        // If more than a week, then take into account the length of months
        if ($diff >= 604800) {
            list($future['H'], $future['i'], $future['s'], $future['d'], $future['m'], $future['Y']) = explode('/', date('H/i/s/d/m/Y', $futureTime));

            list($past['H'], $past['i'], $past['s'], $past['d'], $past['m'], $past['Y']) = explode('/', date('H/i/s/d/m/Y', $pastTime));
            $weeks = $days = $hours = $minutes = $seconds = 0;

            $years = (int)$future['Y'] - (int)$past['Y'];
            $months = (int)$future['m'] + ((12 * $years) - (int)$past['m']);

            if ($months >= 12) {
                $years = floor($months / 12);
                $months -= ($years * 12);
            }
            if ((int)$future['m'] < (int)$past['m'] && (int)$future['Y'] - (int)$past['Y'] === 1) {
                $years--;
            }

            if ((int)$future['d'] >= (int)$past['d']) {
                $days = (int)$future['d'] - (int)$past['d'];
            } else {
                $daysInPastMonth = (int)date('t', $pastTime);
                $daysInFutureMonth = (int)date('t', mktime(0, 0, 0, (int)$future['m'] - 1, 1, (int)$future['Y']));

                if (!$backwards) {
                    $days = ($daysInPastMonth - (int)$past['d']) + (int)$future['d'];
                } else {
                    $days = ($daysInFutureMonth - (int)$past['d']) + (int)$future['d'];
                }

                if ($future['m'] != $past['m']) {
                    $months--;
                }
            }

            if (!$months && $years >= 1 && $diff < ($years * 31536000)) {
                $months = 11;
                $years--;
            }

            if ($months >= 12) {
                $years++;
                $months -= 12;
            }

            if ($days >= 7) {
                $weeks = floor($days / 7);
                $days -= ($weeks * 7);
            }
        } else {
            $years = $months = $weeks = 0;
            $days = floor($diff / 86400);

            $diff -= ($days * 86400);

            $hours = floor($diff / 3600);
            $diff -= ($hours * 3600);

            $minutes = floor($diff / 60);
            $diff -= ($minutes * 60);
            $seconds = $diff;
        }

        $fWord = $options['accuracy']['second'];
        if ($years > 0) {
            $fWord = $options['accuracy']['year'];
        } elseif (abs($months) > 0) {
            $fWord = $options['accuracy']['month'];
        } elseif (abs($weeks) > 0) {
            $fWord = $options['accuracy']['week'];
        } elseif (abs($days) > 0) {
            $fWord = $options['accuracy']['day'];
        } elseif (abs($hours) > 0) {
            $fWord = $options['accuracy']['hour'];
        } elseif (abs($minutes) > 0) {
            $fWord = $options['accuracy']['minute'];
        }

        $fNum = str_replace(['year', 'month', 'week', 'day', 'hour', 'minute', 'second'], [1, 2, 3, 4, 5, 6, 7], $fWord);

        return [$fNum, $fWord, $years, $months, $weeks, $days, $hours, $minutes, $seconds];
    }

    /**
     * Format a into a relative date string.
     *
     * @param \DateTimeInterface $date The date to format.
     * @param array $options Array of options.
     * @return string Relative date string.
     * @see \Cake\I18n\Date::timeAgoInWords()
     */
    public function dateAgoInWords(DateTimeInterface $date, array $options = [])
    {
        $options = $this->_options($options, FrozenDate::class);
        if ($options['timezone'] && $date instanceof ChronosInterface) {
            $date = $date->timezone($options['timezone']);
        }

        $now = $options['from']->format('U');
        $inSeconds = $date->format('U');
        $backwards = ($inSeconds > $now);

        $futureTime = $now;
        $pastTime = $inSeconds;
        if ($backwards) {
            $futureTime = $inSeconds;
            $pastTime = $now;
        }
        $diff = $futureTime - $pastTime;

        if (!$diff) {
            return __d('cake', 'hoje');
        }

        if ($diff > abs($now - (new FrozenDate($options['end']))->format('U'))) {
            return sprintf($options['absoluteString'], $date->i18nFormat($options['format']));
        }

        $diffData = $this->_diffData($futureTime, $pastTime, $backwards, $options);
        list($fNum, $fWord, $years, $months, $weeks, $days) = array_values($diffData);

        $relativeDate = [];
        if ($fNum >= 1 && $years > 0) {
            $relativeDate[] = __dn('cake', '{0} ano', '{0} anos', $years, $years);
        }
        if ($fNum >= 2 && $months > 0) {
            $relativeDate[] = __dn('cake', '{0} mês', '{0} meses', $months, $months);
        }
        if ($fNum >= 3 && $weeks > 0) {
            $relativeDate[] = __dn('cake', '{0} semana', '{0} semanas', $weeks, $weeks);
        }
        if ($fNum >= 4 && $days > 0) {
            $relativeDate[] = __dn('cake', '{0} dia', '{0} dias', $days, $days);
        }
        $relativeDate = implode(', ', $relativeDate);

        // When time has passed
        if (!$backwards) {
            $aboutAgo = [
                'day' => __d('cake', 'cerca de um dia atrás'),
                'week' => __d('cake', 'cerca de uma semana atrás'),
                'month' => __d('cake', 'cerca um mês atrás'),
                'year' => __d('cake', 'cerca de um ano atrás'),
            ];

            return $relativeDate ? sprintf($options['relativeString'], $relativeDate) : $aboutAgo[$fWord];
        }

        // When time is to come
        if ($relativeDate) {
            return $relativeDate;
        }
        $aboutIn = [
            'day' => __d('cake', 'em cerca de um dia'),
            'week' => __d('cake', 'em cerca de uma semana'),
            'month' => __d('cake', 'em cerca de um mês'),
            'year' => __d('cake', 'em cerca de um ano'),
        ];

        return $aboutIn[$fWord];
    }

    /**
     * Build the options for relative date formatting.
     *
     * @param array $options The options provided by the user.
     * @param string $class The class name to use for defaults.
     * @return array Options with defaults applied.
     */
    protected function _options($options, $class)
    {
        $options += [
            'from' => $class::now(),
            'timezone' => null,
            'format' => $class::$wordFormat,
            'accuracy' => $class::$wordAccuracy,
            'end' => $class::$wordEnd,
            'relativeString' => __d('cake', '%s atrás'),
            'absoluteString' => __d('cake', 'em %s'),
        ];
        if (is_string($options['accuracy'])) {
            $accuracy = $options['accuracy'];
            $options['accuracy'] = [];
            foreach ($class::$wordAccuracy as $key => $level) {
                $options['accuracy'][$key] = $accuracy;
            }
        } else {
            $options['accuracy'] += $class::$wordAccuracy;
        }

        return $options;
    }
}
