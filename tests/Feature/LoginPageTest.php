<?php

namespace Tests\Feature;

use DOMDocument;
use DOMElement;
use DOMXPath;
use Tests\TestCase;

class LoginPageTest extends TestCase
{
    public function test_login_page_renders_one_complete_csrf_protected_form(): void
    {
        $response = $this->get(route('login'));

        $response->assertOk();

        $document = new DOMDocument();
        $previousErrorSetting = libxml_use_internal_errors(true);
        $document->loadHTML($response->getContent());
        libxml_clear_errors();
        libxml_use_internal_errors($previousErrorSetting);

        $xpath = new DOMXPath($document);
        $forms = $xpath->query('//form[@id="login-form"]');

        $this->assertCount(1, $forms);

        $form = $forms->item(0);

        $this->assertInstanceOf(DOMElement::class, $form);
        $this->assertSame('post', strtolower($form->getAttribute('method')));
        $this->assertSame(route('login'), $form->getAttribute('action'));
        $this->assertCount(1, $xpath->query('.//input[@name="_token" and @type="hidden"]', $form));
        $this->assertCount(1, $xpath->query('.//input[@id="email" and @name="email"]', $form));
        $this->assertCount(1, $xpath->query('.//input[@id="password" and @name="password"]', $form));
        $this->assertCount(1, $xpath->query('.//button[@type="submit"]', $form));

        foreach (['login-form', 'email', 'password'] as $id) {
            $this->assertCount(1, $xpath->query(sprintf('//*[@id="%s"]', $id)));
        }
    }

    public function test_login_validation_still_redirects_with_errors(): void
    {
        $this->post(route('login'), [])
            ->assertRedirect()
            ->assertSessionHasErrors(['email', 'password']);

        $this->assertGuest();
    }
}
