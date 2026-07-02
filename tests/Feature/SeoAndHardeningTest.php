<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('serves a valid XML sitemap', function () {
    $this->get('/sitemap.xml')
        ->assertOk()
        ->assertHeader('content-type', 'application/xml')
        ->assertSee('<urlset', false)
        ->assertSee(url('/'), false);
});

it('301-redirects legacy admission URLs', function () {
    $this->get('/apply-admission')->assertRedirect(url('/admissions'))->assertStatus(301);
    $this->get('/undergraduate-program')->assertStatus(301);
    $this->get('/location')->assertRedirect(url('/contact'));
});

it('sends security headers on public responses', function () {
    $response = $this->get('/');
    $response->assertHeader('X-Content-Type-Options', 'nosniff');
    $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
    $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
});

it('renders SEO meta and organization schema', function () {
    $this->get('/')
        ->assertSee('property="og:title"', false)
        ->assertSee('rel="canonical"', false)
        ->assertSee('CollegeOrUniversity', false);
});

it('shows a friendly custom 404 page', function () {
    $this->get('/definitely-not-a-real-page-xyz')
        ->assertNotFound()
        ->assertSee('Page not found')
        ->assertSee('Back to homepage');
});
