<?php
namespace Connection;

interface IConnectionConfiguration
{
    /**
     * Возвращает адрес подключения к БД.
     *
     * @return string
     */
    public function getHost();

    /**
     * Возвращает имя пользователя для подключения к БД.
     *
     * @return string
     */
    public function getUsername();

    /**
     * Возвращает пароль пользователя для подключения к БД.
     *
     * @return string
     */
    public function getPassword();

    /**
     * Возвращает название БД.
     *
     * @return string
     */
    public function getDatabaseName();
}