<?php

namespace App\Values;

use App\Strategies\User\TalentStorage\ApprenticeWithContratStorage;
use App\Strategies\User\TalentStorage\ApprenticeWithoutContratStorage;
use App\Strategies\User\TalentStorage\CorporateOfficerStorage;
use App\Strategies\User\TalentStorage\CorporateOwnerStorage;
use App\Strategies\User\TalentStorage\EntrepreneurStorage;
use App\Strategies\User\TalentStorage\SenaGraduateStorage;
use App\Strategies\User\TalentStorage\SenaOfficerStorage;
use App\Strategies\User\TalentStorage\SenaInstructorStorage;
use App\Strategies\User\TalentStorage\UniversityStudentStorage;


final  class TalentStorageValues
{
    const TALENTTYPE = [
        'aprendiz_con_apoyo' => ApprenticeWithContratStorage::class,
        'aprendiz_sin_apoyo' => ApprenticeWithoutContratStorage::class,
        'egresado_sena' => SenaGraduateStorage::class,
        'emprendedor' => EntrepreneurStorage::class,
        'estudiante_universitario' => UniversityStudentStorage::class,
        'funcionario_empresa' => CorporateOfficerStorage::class,
        'funcionario_sena' => SenaOfficerStorage::class,
        'instructor_sena' => SenaInstructorStorage::class,
        'propietario_empresa' => CorporateOwnerStorage::class,
    ];
}
