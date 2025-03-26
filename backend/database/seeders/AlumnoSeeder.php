<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlumnoSeeder extends Seeder
{
    public function run(): void
    {
        $alumnos = [
            // Alumnos de 1º ESO A
            [
                'nombre' => 'Carlos',
                'apellidos' => 'López Pérez',
                'nombrePadre' => 'Juan López',
                'telefonoPadre' => '666123456',
                'correoPadre' => 'juan.lopez@email.com',
                'nombreMadre' => 'Ana Pérez',
                'telefonoMadre' => '666987654',
                'correoMadre' => 'ana.perez@email.com',
                'idCurso' => 1
            ],
            [
                'nombre' => 'Lucía',
                'apellidos' => 'García Martínez',
                'nombrePadre' => 'Luis García',
                'telefonoPadre' => '665123123',
                'correoPadre' => 'luis.garcia@email.com',
                'nombreMadre' => 'María Martínez',
                'telefonoMadre' => '665987987',
                'correoMadre' => 'maria.martinez@email.com',
                'idCurso' => 1
            ],
            [
                'nombre' => 'David',
                'apellidos' => 'Fernández Ruiz',
                'nombrePadre' => 'Pedro Fernández',
                'telefonoPadre' => '664321321',
                'correoPadre' => 'pedro.fernandez@email.com',
                'nombreMadre' => 'Laura Ruiz',
                'telefonoMadre' => '664987987',
                'correoMadre' => 'laura.ruiz@email.com',
                'idCurso' => 1
            ],
            // Alumnos de 1º ESO B
            [
                'nombre' => 'Marcos',
                'apellidos' => 'Sánchez López',
                'nombrePadre' => 'Antonio Sánchez',
                'telefonoPadre' => '663111222',
                'correoPadre' => 'antonio.sanchez@email.com',
                'nombreMadre' => 'Sofía López',
                'telefonoMadre' => '663999888',
                'correoMadre' => 'sofia.lopez@email.com',
                'idCurso' => 2
            ],
            [
                'nombre' => 'Paula',
                'apellidos' => 'Torres Martín',
                'nombrePadre' => 'Javier Torres',
                'telefonoPadre' => '662222333',
                'correoPadre' => 'javier.torres@email.com',
                'nombreMadre' => 'Isabel Martín',
                'telefonoMadre' => '662888777',
                'correoMadre' => 'isabel.martin@email.com',
                'idCurso' => 2
            ],
            [
                'nombre' => 'Miguel',
                'apellidos' => 'Hernández González',
                'nombrePadre' => 'Raúl Hernández',
                'telefonoPadre' => '661333444',
                'correoPadre' => 'raul.hernandez@email.com',
                'nombreMadre' => 'Teresa González',
                'telefonoMadre' => '661777666',
                'correoMadre' => 'teresa.gonzalez@email.com',
                'idCurso' => 2
            ],
            // Alumnos de 2º ESO A
            [
                'nombre' => 'Sergio',
                'apellidos' => 'González Martín',
                'nombrePadre' => 'Manuel González',
                'telefonoPadre' => '665456789',
                'correoPadre' => 'manuel.gonzalez@email.com',
                'nombreMadre' => 'Beatriz Martín',
                'telefonoMadre' => '665987654',
                'correoMadre' => 'beatriz.martin@email.com',
                'idCurso' => 3
            ],
            [
                'nombre' => 'Andrea',
                'apellidos' => 'Fernández López',
                'nombrePadre' => 'José Fernández',
                'telefonoPadre' => '664789123',
                'correoPadre' => 'jose.fernandez@email.com',
                'nombreMadre' => 'Laura López',
                'telefonoMadre' => '664123987',
                'correoMadre' => 'laura.lopez@email.com',
                'idCurso' => 3
            ],
            [
                'nombre' => 'Raquel',
                'apellidos' => 'Ruiz Martínez',
                'nombrePadre' => 'Miguel Ruiz',
                'telefonoPadre' => '663123789',
                'correoPadre' => 'miguel.ruiz@email.com',
                'nombreMadre' => 'Patricia Martínez',
                'telefonoMadre' => '663987321',
                'correoMadre' => 'patricia.martinez@email.com',
                'idCurso' => 3
            ],
            // Alumnos de 2º ESO B
            [
                'nombre' => 'Hugo',
                'apellidos' => 'López Torres',
                'nombrePadre' => 'Luis López',
                'telefonoPadre' => '662321654',
                'correoPadre' => 'luis.lopez@email.com',
                'nombreMadre' => 'Ana Torres',
                'telefonoMadre' => '662987456',
                'correoMadre' => 'ana.torres@email.com',
                'idCurso' => 4
            ],
            [
                'nombre' => 'Marta',
                'apellidos' => 'Sánchez González',
                'nombrePadre' => 'Pedro Sánchez',
                'telefonoPadre' => '661654987',
                'correoPadre' => 'pedro.sanchez@email.com',
                'nombreMadre' => 'Isabel González',
                'telefonoMadre' => '661321987',
                'correoMadre' => 'isabel.gonzalez@email.com',
                'idCurso' => 4
            ],
            [
                'nombre' => 'Iván',
                'apellidos' => 'Pérez Fernández',
                'nombrePadre' => 'Raúl Pérez',
                'telefonoPadre' => '660987321',
                'correoPadre' => 'raul.perez@email.com',
                'nombreMadre' => 'Teresa Fernández',
                'telefonoMadre' => '660123456',
                'correoMadre' => 'teresa.fernandez@email.com',
                'idCurso' => 4
            ],
            // Alumnos de 3º ESO A
            [
                'nombre' => 'Alejandro',
                'apellidos' => 'Martín Ruiz',
                'nombrePadre' => 'Javier Martín',
                'telefonoPadre' => '659654321',
                'correoPadre' => 'javier.martin@email.com',
                'nombreMadre' => 'María Ruiz',
                'telefonoMadre' => '659987654',
                'correoMadre' => 'maria.ruiz@email.com',
                'idCurso' => 5
            ],
            [
                'nombre' => 'Sofía',
                'apellidos' => 'García Pérez',
                'nombrePadre' => 'Carlos García',
                'telefonoPadre' => '658321987',
                'correoPadre' => 'carlos.garcia@email.com',
                'nombreMadre' => 'Elena Pérez',
                'telefonoMadre' => '658987123',
                'correoMadre' => 'elena.perez@email.com',
                'idCurso' => 5
            ],
            [
                'nombre' => 'Daniel',
                'apellidos' => 'Torres López',
                'nombrePadre' => 'José Torres',
                'telefonoPadre' => '657123654',
                'correoPadre' => 'jose.torres@email.com',
                'nombreMadre' => 'Sara López',
                'telefonoMadre' => '657456987',
                'correoMadre' => 'sara.lopez@email.com',
                'idCurso' => 5
            ],
            // Alumnos de 3º ESO B
            [
                'nombre' => 'Natalia',
                'apellidos' => 'López Martínez',
                'nombrePadre' => 'Fernando López',
                'telefonoPadre' => '656789321',
                'correoPadre' => 'fernando.lopez@email.com',
                'nombreMadre' => 'Beatriz Martínez',
                'telefonoMadre' => '656123987',
                'correoMadre' => 'beatriz.martinez@email.com',
                'idCurso' => 6
            ],
            [
                'nombre' => 'Adrián',
                'apellidos' => 'Hernández Sánchez',
                'nombrePadre' => 'Manuel Hernández',
                'telefonoPadre' => '655321654',
                'correoPadre' => 'manuel.hernandez@email.com',
                'nombreMadre' => 'Isabel Sánchez',
                'telefonoMadre' => '655987123',
                'correoMadre' => 'isabel.sanchez@email.com',
                'idCurso' => 6
            ],
            [
                'nombre' => 'Paula',
                'apellidos' => 'Fernández González',
                'nombrePadre' => 'Miguel Fernández',
                'telefonoPadre' => '654987321',
                'correoPadre' => 'miguel.fernandez@email.com',
                'nombreMadre' => 'Lucía González',
                'telefonoMadre' => '654123987',
                'correoMadre' => 'lucia.gonzalez@email.com',
                'idCurso' => 6
            ],
            // Alumnos de 4º ESO A
            [
                'nombre' => 'Laura',
                'apellidos' => 'Martínez Pérez',
                'nombrePadre' => 'Antonio Martínez',
                'telefonoPadre' => '653456789',
                'correoPadre' => 'antonio.martinez@email.com',
                'nombreMadre' => 'Teresa Pérez',
                'telefonoMadre' => '653987654',
                'correoMadre' => 'teresa.perez@email.com',
                'idCurso' => 7
            ],
            [
                'nombre' => 'Mario',
                'apellidos' => 'Ruiz González',
                'nombrePadre' => 'Pedro Ruiz',
                'telefonoPadre' => '652321654',
                'correoPadre' => 'pedro.ruiz@email.com',
                'nombreMadre' => 'Marta González',
                'telefonoMadre' => '652987321',
                'correoMadre' => 'marta.gonzalez@email.com',
                'idCurso' => 7
            ],
            [
                'nombre' => 'Clara',
                'apellidos' => 'Sánchez López',
                'nombrePadre' => 'Luis Sánchez',
                'telefonoPadre' => '651654987',
                'correoPadre' => 'luis.sanchez@email.com',
                'nombreMadre' => 'Patricia López',
                'telefonoMadre' => '651987654',
                'correoMadre' => 'patricia.lopez@email.com',
                'idCurso' => 7
            ],
            // Alumnos de 4º ESO B
            [
                'nombre' => 'Hugo',
                'apellidos' => 'González Martín',
                'nombrePadre' => 'Javier González',
                'telefonoPadre' => '650987321',
                'correoPadre' => 'javier.gonzalez@email.com',
                'nombreMadre' => 'María Martín',
                'telefonoMadre' => '650123987',
                'correoMadre' => 'maria.martin@email.com',
                'idCurso' => 8
            ],
            [
                'nombre' => 'Marina',
                'apellidos' => 'López Torres',
                'nombrePadre' => 'Carlos López',
                'telefonoPadre' => '649321654',
                'correoPadre' => 'carlos.lopez@email.com',
                'nombreMadre' => 'Ana Torres',
                'telefonoMadre' => '649987123',
                'correoMadre' => 'ana.torres@email.com',
                'idCurso' => 8
            ],
            [
                'nombre' => 'Iván',
                'apellidos' => 'Fernández Pérez',
                'nombrePadre' => 'Miguel Fernández',
                'telefonoPadre' => '648654987',
                'correoPadre' => 'miguel.fernandez@email.com',
                'nombreMadre' => 'Teresa Pérez',
                'telefonoMadre' => '648321987',
                'correoMadre' => 'teresa.perez@email.com',
                'idCurso' => 8
            ],
            // Alumnos de 1º Bachillerato A
            [
                'nombre' => 'Alejandro',
                'apellidos' => 'González Sánchez',
                'nombrePadre' => 'Manuel González',
                'telefonoPadre' => '647123654',
                'correoPadre' => 'manuel.gonzalez@email.com',
                'nombreMadre' => 'Beatriz Sánchez',
                'telefonoMadre' => '647456987',
                'correoMadre' => 'beatriz.sanchez@email.com',
                'idCurso' => 9
            ],
            [
                'nombre' => 'Cristina',
                'apellidos' => 'Ruiz Martínez',
                'nombrePadre' => 'Fernando Ruiz',
                'telefonoPadre' => '646789321',
                'correoPadre' => 'fernando.ruiz@email.com',
                'nombreMadre' => 'Patricia Martínez',
                'telefonoMadre' => '646987654',
                'correoMadre' => 'patricia.martinez@email.com',
                'idCurso' => 9
            ],
            [
                'nombre' => 'Raquel',
                'apellidos' => 'Pérez López',
                'nombrePadre' => 'Luis Pérez',
                'telefonoPadre' => '645654987',
                'correoPadre' => 'luis.perez@email.com',
                'nombreMadre' => 'Elena López',
                'telefonoMadre' => '645123987',
                'correoMadre' => 'elena.lopez@email.com',
                'idCurso' => 9
            ],
            // Alumnos de 1º Bachillerato B
            [
                'nombre' => 'David',
                'apellidos' => 'Torres Hernández',
                'nombrePadre' => 'Carlos Torres',
                'telefonoPadre' => '644987654',
                'correoPadre' => 'carlos.torres@email.com',
                'nombreMadre' => 'Isabel Hernández',
                'telefonoMadre' => '644123456',
                'correoMadre' => 'isabel.hernandez@email.com',
                'idCurso' => 10
            ],
            [
                'nombre' => 'Sonia',
                'apellidos' => 'García Fernández',
                'nombrePadre' => 'José García',
                'telefonoPadre' => '643654321',
                'correoPadre' => 'jose.garcia@email.com',
                'nombreMadre' => 'Laura Fernández',
                'telefonoMadre' => '643987654',
                'correoMadre' => 'laura.fernandez@email.com',
                'idCurso' => 10
            ],
            [
                'nombre' => 'Mario',
                'apellidos' => 'Martínez Pérez',
                'nombrePadre' => 'Antonio Martínez',
                'telefonoPadre' => '642321654',
                'correoPadre' => 'antonio.martinez@email.com',
                'nombreMadre' => 'Sara Pérez',
                'telefonoMadre' => '642987123',
                'correoMadre' => 'sara.perez@email.com',
                'idCurso' => 10
            ],
            // Alumnos de 2º Bachillerato A
            [
                'nombre' => 'Adrián',
                'apellidos' => 'García López',
                'nombrePadre' => 'Pedro García',
                'telefonoPadre' => '641654987',
                'correoPadre' => 'pedro.garcia@email.com',
                'nombreMadre' => 'Eva López',
                'telefonoMadre' => '641987321',
                'correoMadre' => 'eva.lopez@email.com',
                'idCurso' => 11
            ],
            [
                'nombre' => 'Elena',
                'apellidos' => 'Torres Martín',
                'nombrePadre' => 'Javier Torres',
                'telefonoPadre' => '640321654',
                'correoPadre' => 'javier.torres@email.com',
                'nombreMadre' => 'Sofía Martín',
                'telefonoMadre' => '640654987',
                'correoMadre' => 'sofia.martin@email.com',
                'idCurso' => 11
            ],
            [
                'nombre' => 'Paula',
                'apellidos' => 'Hernández Sánchez',
                'nombrePadre' => 'Miguel Hernández',
                'telefonoPadre' => '639987123',
                'correoPadre' => 'miguel.hernandez@email.com',
                'nombreMadre' => 'Isabel Sánchez',
                'telefonoMadre' => '639123987',
                'correoMadre' => 'isabel.sanchez@email.com',
                'idCurso' => 11
            ],
            // Alumnos de 2º Bachillerato B
            [
                'nombre' => 'Cristina',
                'apellidos' => 'Fernández Ruiz',
                'nombrePadre' => 'Luis Fernández',
                'telefonoPadre' => '638987654',
                'correoPadre' => 'luis.fernandez@email.com',
                'nombreMadre' => 'Marta Ruiz',
                'telefonoMadre' => '638123456',
                'correoMadre' => 'marta.ruiz@email.com',
                'idCurso' => 12
            ],
            [
                'nombre' => 'Raquel',
                'apellidos' => 'López González',
                'nombrePadre' => 'Javier López',
                'telefonoPadre' => '637654987',
                'correoPadre' => 'javier.lopez@email.com',
                'nombreMadre' => 'Patricia González',
                'telefonoMadre' => '637987321',
                'correoMadre' => 'patricia.gonzalez@email.com',
                'idCurso' => 12
            ],
            [
                'nombre' => 'Iván',
                'apellidos' => 'Martín Pérez',
                'nombrePadre' => 'Carlos Martín',
                'telefonoPadre' => '636321654',
                'correoPadre' => 'carlos.martin@email.com',
                'nombreMadre' => 'Beatriz Pérez',
                'telefonoMadre' => '636987123',
                'correoMadre' => 'beatriz.perez@email.com',
                'idCurso' => 12
            ],
            // Alumnos de FP Básica 1
            [
                'nombre' => 'Javier',
                'apellidos' => 'Martínez Romero',
                'nombrePadre' => 'Alberto Martínez',
                'telefonoPadre' => '675456789',
                'correoPadre' => 'alberto.martinez@email.com',
                'nombreMadre' => 'Eva Romero',
                'telefonoMadre' => '675123789',
                'correoMadre' => 'eva.romero@email.com',
                'idCurso' => 13
            ],
            [
                'nombre' => 'Sara',
                'apellidos' => 'Pérez López',
                'nombrePadre' => 'Miguel Pérez',
                'telefonoPadre' => '674987654',
                'correoPadre' => 'miguel.perez@email.com',
                'nombreMadre' => 'Laura López',
                'telefonoMadre' => '674123987',
                'correoMadre' => 'laura.lopez@email.com',
                'idCurso' => 13
            ],
            [
                'nombre' => 'Raúl',
                'apellidos' => 'Sánchez García',
                'nombrePadre' => 'Fernando Sánchez',
                'telefonoPadre' => '673654987',
                'correoPadre' => 'fernando.sanchez@email.com',
                'nombreMadre' => 'María García',
                'telefonoMadre' => '673987321',
                'correoMadre' => 'maria.garcia@email.com',
                'idCurso' => 13
            ],
            // Alumnos de FP Básica 2
            [
                'nombre' => 'Antonio',
                'apellidos' => 'López Torres',
                'nombrePadre' => 'José López',
                'telefonoPadre' => '672321654',
                'correoPadre' => 'jose.lopez@email.com',
                'nombreMadre' => 'Carmen Torres',
                'telefonoMadre' => '672654321',
                'correoMadre' => 'carmen.torres@email.com',
                'idCurso' => 14
            ],
            [
                'nombre' => 'Laura',
                'apellidos' => 'García Fernández',
                'nombrePadre' => 'Luis García',
                'telefonoPadre' => '671456321',
                'correoPadre' => 'luis.garcia@email.com',
                'nombreMadre' => 'Ana Fernández',
                'telefonoMadre' => '671789123',
                'correoMadre' => 'ana.fernandez@email.com',
                'idCurso' => 14
            ],
            [
                'nombre' => 'Daniel',
                'apellidos' => 'Martín Sánchez',
                'nombrePadre' => 'Pedro Martín',
                'telefonoPadre' => '670789456',
                'correoPadre' => 'pedro.martin@email.com',
                'nombreMadre' => 'Isabel Sánchez',
                'telefonoMadre' => '670321789',
                'correoMadre' => 'isabel.sanchez@email.com',
                'idCurso' => 14
            ],
            // Alumnos de Grado Medio 1
            [
                'nombre' => 'Alejandro',
                'apellidos' => 'Ruiz Martínez',
                'nombrePadre' => 'Javier Ruiz',
                'telefonoPadre' => '669123987',
                'correoPadre' => 'javier.ruiz@email.com',
                'nombreMadre' => 'Lucía Martínez',
                'telefonoMadre' => '669987123',
                'correoMadre' => 'lucia.martinez@email.com',
                'idCurso' => 15
            ],
            [
                'nombre' => 'Marina',
                'apellidos' => 'López Hernández',
                'nombrePadre' => 'Carlos López',
                'telefonoPadre' => '668987321',
                'correoPadre' => 'carlos.lopez@email.com',
                'nombreMadre' => 'Sofía Hernández',
                'telefonoMadre' => '668321987',
                'correoMadre' => 'sofia.hernandez@email.com',
                'idCurso' => 15
            ],
            [
                'nombre' => 'Iván',
                'apellidos' => 'González Torres',
                'nombrePadre' => 'Miguel González',
                'telefonoPadre' => '667654321',
                'correoPadre' => 'miguel.gonzalez@email.com',
                'nombreMadre' => 'Elena Torres',
                'telefonoMadre' => '667123456',
                'correoMadre' => 'elena.torres@email.com',
                'idCurso' => 15
            ],
            // Alumnos de Grado Medio 2
            [
                'nombre' => 'Cristina',
                'apellidos' => 'Pérez Sánchez',
                'nombrePadre' => 'Fernando Pérez',
                'telefonoPadre' => '666789123',
                'correoPadre' => 'fernando.perez@email.com',
                'nombreMadre' => 'Marta Sánchez',
                'telefonoMadre' => '666321987',
                'correoMadre' => 'marta.sanchez@email.com',
                'idCurso' => 16
            ],
            [
                'nombre' => 'Mario',
                'apellidos' => 'Torres López',
                'nombrePadre' => 'José Torres',
                'telefonoPadre' => '665987321',
                'correoPadre' => 'jose.torres@email.com',
                'nombreMadre' => 'Ana López',
                'telefonoMadre' => '665123456',
                'correoMadre' => 'ana.lopez@email.com',
                'idCurso' => 16
            ],
            [
                'nombre' => 'Sonia',
                'apellidos' => 'García Ruiz',
                'nombrePadre' => 'Luis García',
                'telefonoPadre' => '664654321',
                'correoPadre' => 'luis.garcia@email.com',
                'nombreMadre' => 'Patricia Ruiz',
                'telefonoMadre' => '664987654',
                'correoMadre' => 'patricia.ruiz@email.com',
                'idCurso' => 16
            ],
            // Alumnos de Grado Superior 1
            [
                'nombre' => 'Héctor',
                'apellidos' => 'López',
                'nombrePadre' => 'Eduardo',
                'telefonoPadre' => '605111222',
                'correoPadre' => 'eduardo.lopez@example.com',
                'nombreMadre' => 'Teresa',
                'telefonoMadre' => '605333444',
                'correoMadre' => 'teresa.lopez@example.com',
                'idCurso' => 17
            ],
            [
                'nombre' => 'Nerea',
                'apellidos' => 'Muñoz',
                'nombrePadre' => 'Guillermo',
                'telefonoPadre' => '605555666',
                'correoPadre' => 'guillermo.munoz@example.com',
                'nombreMadre' => 'Cristina',
                'telefonoMadre' => '605777888',
                'correoMadre' => 'cristina.munoz@example.com',
                'idCurso' => 17
            ],
            [
                'nombre' => 'Gonzalo',
                'apellidos' => 'Navarro',
                'nombrePadre' => 'Pablo',
                'telefonoPadre' => '605999000',
                'correoPadre' => 'pablo.navarro@example.com',
                'nombreMadre' => 'Marta',
                'telefonoMadre' => '606111222',
                'correoMadre' => 'marta.navarro@example.com',
                'idCurso' => 17
            ],
            // Alumnos de Grado Superior 2
            [
                'nombre' => 'Laura',
                'apellidos' => 'Ortega',
                'nombrePadre' => 'Rafael',
                'telefonoPadre' => '606333444',
                'correoPadre' => 'rafael.ortega@example.com',
                'nombreMadre' => 'Esther',
                'telefonoMadre' => '606555666',
                'correoMadre' => 'esther.ortega@example.com',
                'idCurso' => 18
            ],
            [
                'nombre' => 'Iván',
                'apellidos' => 'Pascual',
                'nombrePadre' => 'Alfredo',
                'telefonoPadre' => '606777888',
                'correoPadre' => 'alfredo.pascual@example.com',
                'nombreMadre' => 'Nuria',
                'telefonoMadre' => '606999000',
                'correoMadre' => 'nuria.pascual@example.com',
                'idCurso' => 18
            ],
            [
                'nombre' => 'Aitana',
                'apellidos' => 'Quintana',
                'nombrePadre' => 'Joaquín',
                'telefonoPadre' => '607111222',
                'correoPadre' => 'joaquin.quintana@example.com',
                'nombreMadre' => 'Clara',
                'telefonoMadre' => '607333444',
                'correoMadre' => 'clara.quintana@example.com',
                'idCurso' => 18
            ]
        ];

        foreach ($alumnos as $alumno) {
            DB::table('alumnos')->insert($alumno);
        }
    }
} 