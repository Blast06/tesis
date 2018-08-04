<?php

// client
Breadcrumbs::for('dashboard', function ($breadcrumbs, $website) {
    $breadcrumbs->push('Dashboard', route('client.dashboard', $website));
});

Breadcrumbs::for('article', function ($breadcrumbs, $website) {
    $breadcrumbs->parent('dashboard', $website);
    $breadcrumbs->push('Articles', route('client.articles.index', $website));
});

Breadcrumbs::for('create-article', function ($breadcrumbs, $website) {
    $breadcrumbs->parent('article', $website);
    $breadcrumbs->push('Create', route('client.articles.create', $website));
});

Breadcrumbs::for('edit-article', function ($breadcrumbs, $website, $article) {
    $breadcrumbs->parent('article', $website);
    $breadcrumbs->push($article->name, $article->url->edit);
});

Breadcrumbs::for('website_config', function ($breadcrumbs, $website) {
    $breadcrumbs->parent('dashboard', $website);
    $breadcrumbs->push($website->name, $website->url->edit);
});

Breadcrumbs::for('message', function ($breadcrumbs, $website) {
    $breadcrumbs->parent('dashboard', $website);
    $breadcrumbs->push('Message', url("/client/{$website->username}/messages"));
});

Breadcrumbs::for('order', function ($breadcrumbs, $website) {
    $breadcrumbs->parent('dashboard', $website);
    $breadcrumbs->push('Ordenes', route('client.orders.index', $website));
});

Breadcrumbs::for('edit-order', function ($breadcrumbs, $website, $order) {
    $breadcrumbs->parent('order', $website);
    $breadcrumbs->push("No. $order->id", route('client.orders.edit', ['website' => $website, 'order' => $order]));
});

Breadcrumbs::for('subscriber', function ($breadcrumbs, $website) {
    $breadcrumbs->parent('dashboard', $website);
    $breadcrumbs->push('Suscriptores', route('client.subscribers.index', $website));
});

Breadcrumbs::for('buyer', function ($breadcrumbs, $website) {
    $breadcrumbs->parent('dashboard', $website);
    $breadcrumbs->push('Compradores', route('client.subscribers.index', $website));
});


