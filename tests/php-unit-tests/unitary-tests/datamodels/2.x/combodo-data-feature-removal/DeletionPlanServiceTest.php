<?php

namespace Combodo\iTop\DataFeatureRemoval\Service\Test;

use Combodo\iTop\DataFeatureRemoval\Entity\DeletionPlanSummaryEntity;
use Combodo\iTop\DataFeatureRemoval\Service\DeletionPlanService;
use Combodo\iTop\Test\UnitTest\ItopCustomDatamodelTestCase;

class DeletionPlanServiceTest extends ItopCustomDatamodelTestCase
{
	public function testExecuteDeletionPlan_DeleteAllWithoutLimit()
	{
		$iDFRToRemoveLeaf = $this->GivenObjectInDB('DFRToRemoveLeaf', ['name' => 'ga']);
		$this->GivenObjectInDB('DFRToUpdate', ['name' => 'bu', 'dfrtoremove_id' => $iDFRToRemoveLeaf]);
		$iDFRRemovedCollateral = $this->GivenObjectInDB('DFRRemovedCollateral', ['name' => 'zo', 'dfrtoremove_id' => $iDFRToRemoveLeaf]);
		$this->GivenObjectInDB('DFRRemovedCollateralCascade', ['name' => 'meu', 'dfrremovedcollateral_id' => $iDFRRemovedCollateral]);

		$aClasses = [ 'DFRToRemoveLeaf' ];
		$aRes = DeletionPlanService::GetInstance()->ExecuteDeletionPlan($aClasses);
		$aExpected = [
			['DFRToUpdate', 1, 0 ],
			['DFRToRemoveLeaf', 0, 1 ],
			['DFRRemovedCollateral', 0, 1 ],
			['DFRRemovedCollateralCascade', 0, 1 ],
		];
		$this->AssertSummaryEquals($aExpected, $aRes, 'DeleteAllWithoutLimit');
	}

	private function AssertSummaryEquals(array $expected, $actual, $sMessage = '')
	{
		$aExpected = [];
		foreach ($expected as $line) {
			$sClass = $line[0];
			$iUpdate = $line[1];
			$iDelete = $line[2];

			$oDeletionPlanSummaryEntity = new DeletionPlanSummaryEntity($sClass);
			$oDeletionPlanSummaryEntity->iUpdateCount = $iUpdate;
			$oDeletionPlanSummaryEntity->iDeleteCount = $iDelete;
			$aExpected[$sClass] = $oDeletionPlanSummaryEntity;
		}
		$this->assertEquals($aExpected, $actual, $sMessage);
	}

	public function testExecuteDeletionPlan_StopInUpdates()
	{
		self::markTestSkipped();
	}

	public function testExecuteDeletionPlan_StopInDeletes()
	{
		self::markTestSkipped();
	}

	public function GetDatamodelDeltaAbsPath(): string
	{
		return __DIR__.'/deletionplan_delta.xml';
	}
}
