<?php

namespace App\controllers;

use Framework\Database;

class ListingsController
{

    protected $db;

    public function __construct()
    {
        $config  = require basePath('config/db.php');
        $this->db = new Database($config);
    }

    public function index()
    {
        $listings = $this->db->query("SELECT * FROM listings")->fetchAll();

        loadView('listings/index', [
            'listings' => $listings
        ]);
    }

    public function create()
    {
        loadView('listings/create');
    }

    public function show($params)
    {
        $id = $params['id'] ?? '';

        $params = [
            'id' => $id
        ];

        $listings = $this->db->query('SELECT * FROM listings WHERE id = :id', $params)->fetch();

        if (!$listings) {
            ErrorController::notFoundError("The listing is not available");
            return;
        }

        loadView('listings/show', [
            'listings' => $listings
        ]);
    }
}
