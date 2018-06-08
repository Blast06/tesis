<?php

// client
Breadcrumbs::for('dashboard', function ($breadcrumbs, $website) {
    $breadcrumbs->push('Dashboard', route('client.dashboard', $website));
});

Breadcrumbs::for('article', function ($breadcrumbs, $website) {
    $breadcrumbs->parent('dashboard', $website);
    $breadcrumbs->push('Articles', route('articles.index', $website));
});

Breadcrumbs::for('create-article', function ($breadcrumbs, $website) {
    $breadcrumbs->parent('article', $website);
    $breadcrumbs->push('Create', route('articles.create', $website));
});

Breadcrumbs::for('edit-article', function ($breadcrumbs, $website, $article) {
    $breadcrumbs->parent('article', $website);
    $breadcrumbs->push($article->name, $article->url->edit);
});

Breadcrumbs::for('website_config', function ($breadcrumbs, $website) {
    $breadcrumbs->parent('dashboard', $website);
    $breadcrumbs->push($website->name, route('websites.edit', $website));
});

Breadcrumbs::for('message', function ($breadcrumbs, $website) {
    $breadcrumbs->parent('dashboard', $website);
    $breadcrumbs->push('Message', url("/client/{$website->username}/messages"));
});

