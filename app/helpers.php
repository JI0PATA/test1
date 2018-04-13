<?php

/**
 * Получение возраста
 * @param $timestamp
 * @return int
 */
function getAge($timestamp): int
{
    $date = date('d/m/Y', $timestamp);
    $ds = explode('/', $date);

    $dateNow = time();
    $day = date('d', $dateNow);
    $month = date('m', $dateNow);
    $year = date('Y', $dateNow);

    $age = $year - $ds[2];

    if ($month . $day < $ds[1] . $ds[0]) $age--;
    return $age;
}

/**
 * Получение возраста текущего пользователя
 * @return int
 */
function getAgeUser(): int
{
    if (!Auth::check()) return 0;
    $birthdate = Auth::user()->birthdate;
    return getAge($birthdate);
}