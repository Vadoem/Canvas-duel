<?php

namespace App\Http\Controllers;

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\Style\Font;
use PhpOffice\PhpWord\IOFactory;


class DocumentController extends Controller
{
    public function generateDocument($studentId)
{
    // Получение данных студента из базы данных
    $student = Student::findOrFail($studentId);
    
    // Создание нового объекта PHPWord
    $phpWord = new PhpWord();
    $section = $phpWord->addSection();

    // Добавление текста в документ
    $section->addText('Имя: ' . $student->name);
    $section->addText('Фамилия: ' . $student->surname);
    $section->addText('Отчество: ' . $student->patronymic);
    
    // Сохранение документа во временном файле
    $tempFilePath = tempnam(sys_get_temp_dir(), 'document') . '.docx';
    $phpWord->save($tempFilePath);
    
    // Отправка файла пользователю для скачивания
    return response()->download($tempFilePath, 'anketa.docx')->deleteFileAfterSend(true);
}
}
