--
-- PostgreSQL database cluster dump
--

-- Started on 2024-12-06 18:48:44

SET default_transaction_read_only = off;

SET client_encoding = 'WIN1252';
SET standard_conforming_strings = on;

--
-- Roles
--

CREATE ROLE admin;
ALTER ROLE admin WITH SUPERUSER INHERIT CREATEROLE CREATEDB LOGIN REPLICATION BYPASSRLS PASSWORD 'SCRAM-SHA-256$4096:iYAx7kX60FsZBlPXqRgKAw==$9x+TgZ+vUf5n6LWbGJ7bfGy2Q2HZZzT8q4+jcnr8D1o=:eK/CF+uHA94QTrr/yjTBKNqL3OuAq+QUxZWfbbTOS2U=';
CREATE ROLE phant;
ALTER ROLE phant WITH SUPERUSER INHERIT CREATEROLE CREATEDB LOGIN REPLICATION BYPASSRLS;

--
-- User Configurations
--








-- Completed on 2024-12-06 18:48:44

--
-- PostgreSQL database cluster dump complete
--

