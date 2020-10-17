<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SiteTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SiteTable Test Case
 */
class SiteTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SiteTable
     */
    public $Site;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Site',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Site') ? [] : ['className' => SiteTable::class];
        $this->Site = TableRegistry::getTableLocator()->get('Site', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Site);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
