<?php

use Codeception\Util\Drupal\FormField;
use Drupal\Core\Entity\EntityStorageException;
use Drupal\node\Entity\Node;

class DrupalDemoCest
{
  public function _before(AcceptanceTester $I)
  {
  }

  /**
   * Test - I can use drush.
   *
   * @param AcceptanceTester $I
   */
  public function drushTest(AcceptanceTester $I)
  {
    $output = $I->runDrush('role-list');
    $I->seeVar($output);
    $uri = $I->getLoginUri('admin');
    $I->seeVar($uri);
  }

  /**
   * Test - I can create page and tags.
   *
   * @param AcceptanceTester $I
   */
  public function entityTest(AcceptanceTester $I)
  {
    $node = $I->createEntity(['title' => 'My node', 'type' => 'page']);
    $I->seeVar($node->id());
    $term = $I->createEntity(['name' => 'My term', 'vid' => 'tags'], 'taxonomy_term');
    $I->seeVar($term->getName());
  }

  /**
   * Test - I can create test users.
   *
   * @param AcceptanceTester $I
   */
  public function userTest(AcceptanceTester $I)
  {
    $user = $I->logInWithRole('Administrator');
    $I->amOnPage('/user/' . $user->id());
    $I->see($user->getAccountName());
    $I->seeVar($user->getAccountName());
    $I->amOnPage('/user/logout');

    $user_admin = $I->createUserWithRoles(['Administrator', 'authenticated'], 'password');
    $I->logInAs($user_admin->getAccountName());
    $I->amOnPage('/user/' . $user_admin->id());
    $I->see($user_admin->getAccountName());
    $I->seeVar($user_admin->getAccountName());
  }

  /**
   * Test - I can use DrupalWatchdog.
   *
   * @param AcceptanceTester $I
   */
  public function watchdogTest(AcceptanceTester $I)
  {
    $I->prepareLogWatch();

    // Do some other steps.

    $I->checkLogs();
  }

  /**
   * Test - I can use Drupal Fields Utility.
   *
   * @param AcceptanceTester $I
   * @throws EntityStorageException
   */
  public function fieldsUtilityTest(AcceptanceTester $I)
  {
    $I->logInAs('admin');
    $I->amOnPage('/node/add/article');
    $I->fillTextField(FormField::title(), 'My article');
    $I->fillWysiwygEditor(FormField::body(), 'My body');
    $I->clickOn(FormField::submit());
    $I->see('My article');
    $I->see('My body');
    $I->click('.messages__wrapper a');
    $url = $I->grabFromCurrentUrl();
    $I->seeVar($url);
    $node_id = str_replace("/node/", "", $url);
    $I->seeVar($node_id);
    Node::load($node_id)->delete();
  }

  public function _after(AcceptanceTester $I)
  {
  }

}
