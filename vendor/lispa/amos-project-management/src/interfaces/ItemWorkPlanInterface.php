<?php

namespace lispa\amos\projectmanagement\interfaces;

interface ItemWorkPlanInterface
{
    public function getName();
    public function getStartDate();
    public function getEndDate();
    public function getUserResponsible();
    public function getUserResponsibleId();
    public function getOrganizationResponsible();
    public function getClassPath();
    public function getTypeName();
}