<?php

test('guest is redirected to login when accessing user dashboard', function () {
    $response = $this->get('/user/dashboard');
    $response->assertRedirect('/login');
});

test('guest is redirected to login when accessing katalog list', function () {
    $response = $this->get('/user/katalog');
    $response->assertRedirect('/login');
});

test('guest is redirected to login when accessing product detail', function () {
    $response = $this->get('/user/katalog/netflix-premium-1-bulan');
    $response->assertRedirect('/login');
});

test('guest is redirected to login when accessing langganan aktif', function () {
    $response = $this->get('/user/langganan');
    $response->assertRedirect('/login');
});

test('guest is redirected to login when accessing riwayat transaksi', function () {
    $response = $this->get('/user/transaksi');
    $response->assertRedirect('/login');
});

test('guest is redirected to login when accessing tukar poin', function () {
    $response = $this->get('/user/poin');
    $response->assertRedirect('/login');
});

test('guest is redirected to login when accessing bantuan dan support', function () {
    $response = $this->get('/user/bantuan');
    $response->assertRedirect('/login');
});

test('guest is redirected to login when attempting to checkout', function () {
    $response = $this->post('/user/checkout/netflix-premium-1-bulan');
    $response->assertRedirect('/login');
});
