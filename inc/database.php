<?php

$db = new SQLite3(__DIR__ . '/database.db');
$db->exec("CREATE TABLE IF NOT EXISTS articles (
id INTEGER PRIMARY KEY,
title TEXT,
description TEXT,
url TEXT UNIQUE,
urlToImage TEXT,
saved_at DATETIME DEFAULT CURRENT_TIMESTAMP
)");
