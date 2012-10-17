<?php
class JobeetCleanupTask extends sfBaseTask{
	protected function configure(){
		$this->addOptions(array(
			new sfCommandOption('application',null,sfCommandOption::PARAMETER_REQUIRED,'The Application','frontend'),
			new sfCommandOption('env',null,sfCommandOption::PARAMETER_REQUIRED,'The Envrionment','prod'),
			new sfCommandOption('days',null,sfCommandOption::PARAMETER_REQUIRED,'',90),
		));
		
		$this->namespace='jobeet';
		$this->name='cleanup';
		$this->detailedDescription = '
		The [jobeet:cleanup|INFO] task cleans up the Jobeet database: 
  [./symfony jobeet:cleanup --env=prod --days=90|INFO]
		';
	}
	
	protected function execute($arguments = array(), $options=array()){
		$databaseManager = new sfDatabaseManager($this->configuration);
		$nb = Doctrine_Core::getTable('JobeetJob')->cleanup($options['days']);
		$this->logSection('doctrine', sprintf('remove %d stale jobs',$nb));
	}
}