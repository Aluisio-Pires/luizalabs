<?php

arch()->expect('App')->not->toUse(['die', 'dd', 'dump']);
it('returns a successful response', function (): void {
    $response = $this->get('/');

    $response->assertStatus(200);
});
