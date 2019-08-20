<?php

	namespace App\DataFixtures;

	use App\Entity\Article;
	use App\Entity\Comment;
	use App\Entity\Tag;
	use Doctrine\Bundle\FixturesBundle\Fixture;
	use Doctrine\Common\DataFixtures\DependentFixtureInterface;
	use Doctrine\Common\Persistence\ObjectManager;
	use Exception;
	use Faker\Factory;
	use Faker\Generator;

	abstract class BaseFixtures extends Fixture
	{
		/** @var ObjectManager */
		private $manager;
		/** @var Generator */
		protected $faker;

		private $referencesIndex = [];

		abstract protected function loadData(ObjectManager $manager);

		public function load(ObjectManager $manager)
		{
			$this->manager = $manager;
			$this->faker = Factory::create();
			$this->loadData($manager);
		}

		protected function createMany(string $className, int $count, callable $factory)
		{
			for ($i = 0; $i < $count; $i++) {
				$entity = new $className();
				$factory($entity, $i);
//      $this->manager->persist($entity);
//      $this->manager->flush();
				// store for usage later as App\Entity\ClassName_#COUNT#
//      if (!$this->hasReference($className . '_' . $i)) {
//        $this->addReference($className . '_' . $i, $entity);
//      } else {
//        $this->addReference($className . '_' . $i . '_', $entity);
//      }
			}
		}

		/**
		 * @param string $className
		 * @return object
		 * @throws Exception
		 */
		protected function getRandomReference(string $className)
		{
			if (!isset($this->referencesIndex[$className])) {
				$this->referencesIndex[$className] = [];
				foreach ($this->referenceRepository->getReferences() as $key => $ref) {
					if (strpos($key, $className . '_') === 0) {
						$this->referencesIndex[$className][] = $key;
					}
				}
			}
			if (empty($this->referencesIndex[$className])) {
				throw new Exception(sprintf('Cannot find any references for class "%s"', $className));
			}
			$randomReferenceKey = $this->faker->randomElement($this->referencesIndex[$className]);
			return $this->getReference($randomReferenceKey);
		}

		/**
		 * @param string $className
		 * @param int $count
		 * @return array
		 * @throws Exception
		 */
		protected function getRandomReferences(string $className, int $count)
		{
			$references = [];
			while (count($references) < $count) {
				$references[] = $this->getRandomReference($className);
			}
			return $references;
		}
	}
