<?php

namespace App\Service\Enum;

enum PersonOptions
{
    /**
     * @return string[]
     */
    public static function getSexOptions(): array
    {
        return [
            'Masculino' => 'm',
            'Feminino' => 'f',
            'Outro' => 'o',
        ];
    }

    /**
     * @param string|null $sex
     * @return string
     */
    public static function getSexOption(?string $sex): string
    {
        return match ($sex) {
            'm' => 'Masculino',
            'f' => 'Feminino',
            'o' => 'Outro',
            default => 'Não informado',
        };
    }

    /**
     * @return string[]
     */
    public static function getSkinColorOptions(): array
    {
        return [
            'Branco' => 'w', // white
            'Pardo' => 'b', // brown
            'Preto' => 'k', // black
            'Amarelo' => 'y', // yellow
            'Indígena' => 'i', // indigenous
        ];
    }

    /**
     * @param string|null $skinColor
     * @return string
     */
    public static function getSkinColorOption(?string $skinColor): string
    {
        return match ($skinColor) {
            'w' => 'Branco',
            'b' => 'Pardo',
            'k' => 'Preto',
            'y' => 'Amarelo',
            'i' => 'Indígena',
            default => 'Não informado',
        };
    }

    /**
     * @return string[]
     */
    public static function genderIdentityOptions(): array
    {
        return [
            'Cisgênero' => 'c',
            'Transgênero' => 't',
            'Não binário' => 'n',
            'Outro' => 'o',
        ];
    }

    /**
     * @param string|null $genderIdentity
     * @return string
     */
    public static function getGenderIdentityOption(?string $genderIdentity): string
    {
        return match ($genderIdentity) {
            'c' => 'Cisgênero',
            't' => 'Transgênero',
            'n' => 'Não binário',
            'o' => 'Outro',
            default => 'Não informado',
        };
    }

    /**
     * @return string[]
     */
    public static function sexualOrientationOptions(): array
    {
        return [
            'Heterossexual' => 'h',
            'Homossexual' => 'm',
            'Bissexual' => 'b',
            'Pansexual' => 'p',
            'Assexual' => 'a',
            'Outro' => 'o',
        ];
    }

    /**
     * @param string|null $sexualOrientation
     * @return string
     */
    public static function getSexualOrientationOption(?string $sexualOrientation): string
    {
        return match ($sexualOrientation) {
            'h' => 'Heterossexual',
            'm' => 'Homossexual',
            'b' => 'Bissexual',
            'p' => 'Pansexual',
            'a' => 'Assexual',
            'o' => 'Outro',
            default => 'Não informado',
        };
    }

    /**
     * @return string[]
     */
    public static function genderExpressionOptions(): array
    {
        return [
            'Feminino' => 'f',
            'Masculino' => 'm',
            'Não binário' => 'n',
            'Outro' => 'o',
        ];
    }

    /**
     * @param string|null $genderExpression
     * @return string
     */
    public static function getGenderExpressionOption(?string $genderExpression): string
    {
        return match ($genderExpression) {
            'f' => 'Feminino',
            'm' => 'Masculino',
            'n' => 'Não binário',
            'o' => 'Outro',
            default => 'Não informado',
        };
    }

    /**
     * @return string[]
     */
    public static function getHousingOptions(): array
    {
        return [
            'Própria' => 'n', // own
            'Alugada' => 'r', // rented
            'Cedida' => 'g', // given
            'Outro' => 'o', // other
        ];
    }

    /**
     * @param string|null $house
     * @return string
     */
    public static function getHouseOption(?string $house): string
    {
        return match ($house) {
            'n' => 'Própria',
            'r' => 'Alugada',
            'g' => 'Cedida',
            'o' => 'Outro',
            default => 'Não informado',
        };
    }

    /**
     * @return string[]
     */
    public static function getMaritalStatusOptions(): array
    {
        return [
            'Solteiro' => 's', // single
            'Casado' => 'm', // married
            'Divorciado' => 'd', // divorced
            'Viúvo' => 'w', // widower
            'Outro' => 'o', // other
        ];
    }

    /**
     * @param string|null $maritalStatus
     * @return string
     */
    public static function getMaritalStatusOption(?string $maritalStatus): string
    {
        return match ($maritalStatus) {
            's' => 'Solteiro',
            'm' => 'Casado',
            'd' => 'Divorciado',
            'w' => 'Viúvo',
            'o' => 'Outro',
            default => 'Não informado',
        };
    }


    /**
     * @return string[]
     */
    public static function getEducationLevelOptions(): array
    {
        return [
            'Analfabeto' => 'a', // illiterate
            'Ensino fundamental incompleto' => 'f', // incomplete elementary school
            'Ensino fundamental completo' => 'c', // complete elementary school
            'Ensino médio incompleto' => 'm', // incomplete high school
            'Ensino médio completo' => 'h', // complete high school
            'Ensino superior incompleto' => 'u', // incomplete higher education
            'Ensino superior completo' => 's', // complete higher education
            'Pós-graduação' => 'p', // postgraduate
            'Mestrado' => 'e', // master's degree
            'Doutorado' => 'd', // doctorate
            'Outro' => 'o', // other
        ];
    }


    /**
     * @param string|null $educationLevel
     * @return string
     */
    public static function getEducationLevelOption(?string $educationLevel): string
    {
        return match ($educationLevel) {
            'a' => 'Analfabeto',
            'f' => 'Ensino fundamental incompleto',
            'c' => 'Ensino fundamental completo',
            'm' => 'Ensino médio incompleto',
            'h' => 'Ensino médio completo',
            'u' => 'Ensino superior incompleto',
            's' => 'Ensino superior completo',
            'p' => 'Pós-graduação',
            'e' => 'Mestrado',
            'd' => 'Doutorado',
            'o' => 'Outro',
            default => 'Não informado',
        };
    }


    /**
     * @return string[]
     */
    public static function getOccupationOptions(): array
    {
        return [
            'Agricultor' => 'a', // farmer
            'Aposentado' => 'r', // retired
            'Autônomo' => 'u', // self-employed
            'Desempregado' => 'n', // unemployed
            'Empregado' => 'e', // employee
            'Empresário' => 'b', // businessman
            'Estudante' => 's', // student
            'Outro' => 'o', // other
        ];
    }


    /**
     * @param string|null $occupation
     * @return string
     */
    public static function getOccupationOption(?string $occupation): string
    {
        return match ($occupation) {
            'a' => 'Agricultor',
            'r' => 'Aposentado',
            'u' => 'Autônomo',
            'n' => 'Desempregado',
            'e' => 'Empregado',
            'b' => 'Empresário',
            's' => 'Estudante',
            'o' => 'Outro',
            default => 'Não informado',
        };
    }


    /**
     * @return string[]
     */
    public static function getReligionOptions(): array
    {
        return [
            'Ateu' => 'a', // atheist
            'Budista' => 'b', // buddhist
            'Católico' => 'c', // catholic
            'Candomblé' => 'd', // candomblé
            'Evangélico' => 'e', // evangelical
            'Espírita' => 's', // spiritist
            'Hinduísta' => 'h', // hinduist
            'Judeu' => 'j', // jewish
            'Muçulmano' => 'm', // muslim
            'Protestante' => 'p', // protestant
            'Outro' => 'o', // other
        ];
    }


    /**
     * @param string|null $religion
     * @return string
     */
    public static function getReligionOption(?string $religion): string
    {
        return match ($religion) {
            'a' => 'Ateu',
            'b' => 'Budista',
            'c' => 'Católico',
            'd' => 'Candomblé',
            'e' => 'Evangélico',
            's' => 'Espírita',
            'h' => 'Hinduísta',
            'j' => 'Judeu',
            'm' => 'Muçulmano',
            'p' => 'Protestante',
            'o' => 'Outro',
            default => 'Não informado',
        };
    }

    /**
     * @return string[]
     */
    public static function getVoterOptions(): array
    {
        return [
            'Sim' => 'y', // yes
            'Não' => 'n', // no
        ];
    }

    /**
     * @param string|null $voter
     * @return string
     */
    public static function getVoterOption(?string $voter): string
    {
        return match ($voter) {
            'y' => 'Sim',
            'n' => 'Não',
            default => 'Não informado',
        };
    }
    // Deficiency Type Options
    public static function getDeficiencyTypeOptions(): array
    {
        return [
            'Auditiva' => 'a', // hearing
            'Visual' => 'v', // visual
            'Física' => 'f', // physical
            'Intelectual' => 'i', // intellectual
            'Outro' => 'o', // other
        ];
    }
    // Deficiency Type Option
    public static function getDeficiencyTypeOption(?string $deficiencyType): string
    {
        return match ($deficiencyType) {
            'a' => 'Auditiva',
            'v' => 'Visual',
            'f' => 'Física',
            'i' => 'Intelectual',
            'o' => 'Outro',
            default => 'Não informado',
        };
    }
}
