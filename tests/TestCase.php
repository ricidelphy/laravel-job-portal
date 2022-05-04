<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Factories\HasFactory;

abstract class TestCase extends BaseTestCase
{
    use HasFactory, CreatesApplication, WithFaker, DatabaseTransactions;
}
