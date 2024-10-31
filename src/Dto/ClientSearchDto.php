<?php
namespace App\Dto;
use Symfony\Component\Validator\Constraints as Assert;



class ClientSearchDto{
    // #[Assert\Regex(
    //     pattern: '/^(77|78|76)([0-9]{7})$/',
    //     message: 'Le telephone doit commencer par 77, 78 ou 76 et avoir 9 chiffres'
    // )]
    private String $telephone;
    private String $nom;


}
