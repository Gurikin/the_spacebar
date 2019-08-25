<?php
/**
 * Created by PhpStorm.
 * User: gurik
 * Date: 24.08.19
 * Time: 22:39
 */

namespace App\Form\Model;


use App\Validator\UniqueUser;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class UserRegistrationFormModel
 * @package App\Form\Model
 */
class UserRegistrationFormModel
{
	/**
	 * @Assert\NotBlank(message="Please enter an email")
	 * @Assert\Email()
	 * @UniqueUser()
	 */
	public $email;

	/**
	 * @Assert\NotBlank(message="Choose a password!")
	 * @Assert\Length(min=5, minMessage="Come on, you can think of a password longer than that!")
	 */
	public $plainPassword;

	/**
	 * @Assert\IsTrue(message="I know, it's silly, but you must agree to our terms.")
	 */
	public $agreeTerms;
}