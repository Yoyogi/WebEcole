<?php // GEN Students AT 2011-12-02 12:27:11
$return = new pdoMap_Dao_Metadata_Table(
                        'students','etudiant','StudentsEntityImpl',
                        '','StudentsAdapterImpl','*');
$return->fields['id'] = new pdoMap_Dao_Metadata_Field(
'id_etudiant',
'id',
'Primary',
array (
)
);
$return->fields['name'] = new pdoMap_Dao_Metadata_Field(
'nom',
'name',
'Char',
array (
  'size' => '45',
)
);
$return->fields['surname'] = new pdoMap_Dao_Metadata_Field(
'prenom',
'surname',
'Char',
array (
  'size' => '45',
)
);
$return->fields['birthday'] = new pdoMap_Dao_Metadata_Field(
'date_naissance',
'birthday',
'Date',
array (
)
);
$return->fields['adress'] = new pdoMap_Dao_Metadata_Field(
'rue',
'adress',
'Char',
array (
  'size' => '45',
)
);
$return->fields['zipCode'] = new pdoMap_Dao_Metadata_Field(
'cp',
'zipCode',
'Char',
array (
  'size' => '11',
)
);
$return->fields['city'] = new pdoMap_Dao_Metadata_Field(
'ville',
'city',
'Char',
array (
  'size' => '45',
)
);
$return->fields['mail'] = new pdoMap_Dao_Metadata_Field(
'email',
'mail',
'Char',
array (
  'size' => '45',
)
);
$return->fields['login'] = new pdoMap_Dao_Metadata_Field(
'ulogin',
'login',
'Char',
array (
  'size' => '45',
)
);
$return->fields['passwd'] = new pdoMap_Dao_Metadata_Field(
'passwd',
'passwd',
'Char',
array (
  'size' => '45',
)
);
$return->fields['photo'] = new pdoMap_Dao_Metadata_Field(
'photo',
'photo',
'Char',
array (
  'size' => '250',
)
);
return $return;
