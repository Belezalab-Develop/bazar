<?php

namespace Bazar\Tests\Unit;

use Bazar\Database\Factories\ProductFactory;
use Bazar\Database\Factories\VariationFactory;
use Bazar\Tests\TestCase;

class VariationTest extends TestCase
{
    protected $variation, $product;

    public function setUp(): void
    {
        parent::setUp();

        $this->product = ProductFactory::new()->create();

        $this->variation = VariationFactory::new()->make();
        $this->variation->product()->associate($this->product);
        $this->variation->save();
    }

    /** @test */
    public function it_belongs_to_a_product()
    {
        $this->assertEquals($this->product->id, $this->variation->product_id);
    }

    /** @test */
    public function it_has_alias_attribute()
    {
        $variation = VariationFactory::new()->make(['alias' => 'Fake']);

        $this->assertSame('Fake', $variation->alias);

        $variation->alias = null;
        $variation->product()->associate($this->product);
        $variation->save();

        $this->assertSame("#{$variation->id}", $variation->alias);
    }
}
