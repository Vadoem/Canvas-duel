<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Spatie\ArrayToXml\ArrayToXml;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\Style\Font;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\Shared\Converter;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use ZipArchive;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        return response()->json($students);
    }

    public function show($id)
    {
        $student = Student::find($id);

        if ($student) {
            return response()->json($student);
        } else {
            return response()->json(['message' => 'Student not found'], 404);
        }
    }

    public function store(Request $request)
{
    // Логирование входящих данных для диагностики
    \Log::info('Полученные данные запроса:', $request->all());

    // Валидация данных запроса
    $validatedData = $request->validate([
        'name' => 'required',
        'surname' => 'required',
        'patronymic' => 'required',
        'worker' => 'required',
        'birthdate' => 'required|date',
        'age' => 'required',
        'university' => 'required',
        'course' => 'required',
        'study_program' => 'required',
        'practice_type' => 'required',
        'start_date' => 'required|date',
        'end_date' => 'required|date',
        'education_form' => 'required',
        'company_phone' => 'required',
        'Форма_обучения' => 'required',
        'Номер_телефона' => 'required',
        'Адрес_Регистрации' => 'required',
        'Почта' => 'required|email',
        'Пол' => 'required',
        'university_supervisor' => 'required',
        'supervisor_name' => 'required',
        'supervisor_position' => 'required',
        'employee_name' => 'required',
        'employee_position' => 'required|date',
        'company_name' => 'required',
    ]);

    try {
        $student = Student::create($validatedData);
        return response()->json($student, 201);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Ошибка при создании студента'], 500);
    }
}





    public function exportToXml()
    {
        // Получаем все записи студентов из базы данных
        $students = Student::all();
    
        // Преобразуем данные в формат XML
        $xml = ArrayToXml::convert($students->toArray(), 'students', true, 'UTF-8', '1.0');
    
        return response($xml)
            ->header('Content-Type', 'application/xml')
            ->header('Content-Disposition', 'attachment; filename=students.xml');
    }

    public function update(Request $request, $id)
    {
        $student = Student::find($id);

        if ($student) {
            // Присваивайте значения полученные из запроса к объекту модели Student
            // Например:
            $student->name = $request->input('name');
            $student->surname = $request->input('surname');
            $student->patronymic = $request->input('patronymic');
            $student->worker = $request->input('worker');
            $student->birthdate = $request->input('birthdate');
            $student->age = $request->input('age');
            $student->university = $request->input('university');
        $student->course = $request->input('course');
        $student->study_program = $request->input('study_program');
        $student->practice_type = $request->input('practice_type');
        $student->start_date = $request->input('start_date');
        $student->end_date = $request->input('end_date');
        $student->university_supervisor = $request->input('university_supervisor');
        $student->education_form = $request->input('education_form');
         $student->company_phone = $request->input('company_phone');
         $student->Адрес_Регистрации = $request->input('Адрес_Регистрации');
         $student->Форма_обучения = $request->input('Форма_обучения');
         $student->Номер_телефона = $request->input('Номер_телефона');
         $student->Почта = $request->input('Почта');
         $student->Пол = $request->input('Пол');
         $student->supervisor_name = $request->input('supervisor_name');
         $student->supervisor_position = $request->input('supervisor_position');
         $student->employee_name = $request->input('employee_name');
         $student->employee_position = $request->input('employee_position');
         $student->employee_position = $request->input('company_name');
    
            // Продолжайте для остальных полей
            
            $student->save();
            return response()->json($student);
        } else {
            return response()->json(['message' => 'Student not found'], 404);
        }
    }
    public function generateDocument(Request $request)
    {
        
    $requestData = json_decode($request->getContent(), true);
    $selectedStudents = $requestData;

    if (empty($selectedStudents)) {
        return response()->json(['message' => 'Не выбраны студенты для анкеты'], 400);
    }

    // Путь к временному файлу архива
    $zipFilePath = tempnam(sys_get_temp_dir(), 'anketa_') . '.zip';
    
    // Инициализация класса ZipArchive
    $zip = new ZipArchive();
    if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
        return response()->json(['message' => 'Не удалось создать архив'], 500);
    }
    
    // Путь к шаблону документа
    $templatePath = public_path('templates/anketa_template.docx');
    
    foreach ($selectedStudents as $student) {
        // Получение данных студента из базы данных
        $student = Student::find($student['id']);
    
        if (!$student) {
            return response()->json(['message' => 'Студент не найден'], 404);
        }
    
        // Генерация уникального имени файла для каждого студента
        $outputPath = public_path('generated_documents/anketa_' . $student->id . '.docx');
    
        // Инициализация TemplateProcessor с указанием пути к шаблону
        $templateProcessor = new TemplateProcessor($templatePath);
    
    
        // Замена тегов в шаблоне на данные студента
        $templateProcessor->setValue("{name}", $student->name);
        $templateProcessor->setValue("{surname}", $student->surname);
        $templateProcessor->setValue("{patronymic}", $student->patronymic);
        $templateProcessor->setValue("{worker}", $student->worker);
        $templateProcessor->setValue("{course}", $student->course);
        $templateProcessor->setValue("{education_form}", $student->education_form);
        $templateProcessor->setValue("{birthdate}", $student->birthdate);
        $templateProcessor->setValue("{study_program}", $student->study_program);
        $templateProcessor->setValue("{university}", $student->university);
        $templateProcessor->setValue("{practice_type}", $student->practice_type);
        $templateProcessor->setValue("{start_date}", $student->start_date);
        $templateProcessor->setValue("{end_date}", $student->end_date);
        $templateProcessor->setValue("{university_supervisor}", $student->university_supervisor);
        $templateProcessor->setValue("{company_phone}", $student->company_phone);
        $templateProcessor->setValue("{Адрес_Регистрации}", $student->Адрес_Регистрации);
        $templateProcessor->setValue("{Номер_телефона}", $student->Номер_телефона);
        $templateProcessor->setValue("{Почта}", $student->Почта);
        $templateProcessor->setValue("{Пол}", $student->Пол);
        $templateProcessor->setValue("{Форма_обучения}", $student->Форма_обучения);
        $templateProcessor->setValue("{supervisor_name}", $student->supervisor_name);
        $templateProcessor->setValue("{supervisor_position}", $student->supervisor_position);
        $templateProcessor->setValue("{employee_name}", $student->employee_name);
        $templateProcessor->setValue("{employee_position}", $student->employee_position);
        $templateProcessor->setValue("{company_name}", $student->company_name);
      // Сохранение созданного документа
        
      $zip->addFile($outputPath, 'anketa_' . $student->name . '.docx');
      $templateProcessor->saveAs($outputPath);
      $templateProcessor = null;
    }
    
    $zip->close();
    
    // Отправка архива с сгенерированными документами в ответе
    return response()->download($zipFilePath, 'anketa_documents.zip')->deleteFileAfterSend();
}
    

    public function generateDocument2($studentId)
    {
        // Получение данных студента из базы данных
        $student = Student::find($studentId);
    
        // Проверка, найден ли студент
        if (!$student) {
            return response()->json(['message' => 'Студент не найден'], 404);
        }
    
        // Путь к шаблону документа
        $templatePath = public_path('templates/med_template.docx');
    
        // Путь для сохранения созданного документа
        $outputPath = public_path('generated_documents/med.docx');
    
        // Инициализация TemplateProcessor с указанием пути к шаблону
        $templateProcessor = new TemplateProcessor($templatePath);
    
        // Замена тегов в шаблоне на данные студента
        $templateProcessor->setValue("{name}", $student->name);
        $templateProcessor->setValue("{surname}", $student->surname);
        $templateProcessor->setValue("{patronymic}", $student->patronymic);
        $templateProcessor->setValue("{worker}", $student->worker);
        $templateProcessor->setValue("{course}", $student->course);
        $templateProcessor->setValue("{education_form}", $student->education_form);
        $templateProcessor->setValue("{birthdate}", $student->birthdate);
        $templateProcessor->setValue("{study_program}", $student->study_program);
        $templateProcessor->setValue("{university}", $student->university);
        $templateProcessor->setValue("{practice_type}", $student->practice_type);
        $templateProcessor->setValue("{start_date}", $student->start_date);
        $templateProcessor->setValue("{end_date}", $student->end_date);
        $templateProcessor->setValue("{university_supervisor}", $student->university_supervisor);
        $templateProcessor->setValue("{company_phone}", $student->company_phone);
        $templateProcessor->setValue("{Адрес_Регистрации}", $student->Адрес_Регистрации);
        $templateProcessor->setValue("{Номер_телефона}", $student->Номер_телефона);
        $templateProcessor->setValue("{Почта}", $student->Почта);
        $templateProcessor->setValue("{Пол}", $student->Пол);
        $templateProcessor->setValue("{Форма_обучения}", $student->Форма_обучения);
        $templateProcessor->setValue("{supervisor_name}", $student->supervisor_name);
        $templateProcessor->setValue("{supervisor_position}", $student->supervisor_position);
        $templateProcessor->setValue("{employee_name}", $student->employee_name);
        $templateProcessor->setValue("{employee_position}", $student->employee_position);
        $templateProcessor->setValue("{company_name}", $student->company_name);

        // Сохранение созданного документа
        $templateProcessor->saveAs($outputPath);
    
        // Отправка созданного документа в ответе
        return response()->download($outputPath)->deleteFileAfterSend();
    }
    public function generateExcelReport($studentId)
{
    $inputFileName = storage_path('templates/forms.xls'); // Путь к вашему готовому шаблону Excel файла

    $spreadsheet = new Spreadsheet();
    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);
    $sheet = $spreadsheet->getActiveSheet();

    // Добавляем данные студента в таблицу
    $student = Student::find($studentId);
    $row = $sheet->getHighestRow() + 1;
    $sheet->setCellValue('B'.$row, $student['name']);
    $sheet->setCellValue('A'.$row, $student['surname']);
    $sheet->setCellValue('C'.$row, $student['patronymic']);
    $sheet->setCellValue('E'.$row, $student['company_address']);
    $sheet->setCellValue('G'.$row, $student['company_address']);
    $sheet->setCellValue('F'.$row, $student['study_program']);
    $sheet->setCellValue('H'.$row, $student['start_date']);
    // Добавьте остальные поля студента

    $writer = new Xlsx($spreadsheet);

    // Сохраняем изменения в новом Excel файле
    $tempFilePath = storage_path('generated_documents/generated_report.xlsx'); // Путь для сохранения нового Excel файла
    $writer->save($tempFilePath);

    // Возвращаем новый Excel файл клиенту
    return response()->download($tempFilePath, 'generated_report.xlsx')->deleteFileAfterSend();
}
public function generateExcelReport2(Request $request)
{
    $selectedStudents = $request->json()->all();

    $tempFolderPath = storage_path('generated_documents/'); // Папка для временного хранения созданных Excel файлов
    $zipFilePath = storage_path('generated_documents/report_archive.zip'); // Путь для сохранения zip-архива
    $inputFileName = storage_path('templates/forms.xls'); // Путь к вашему готовому шаблону Excel файла
    // Создаем новый ZipArchive объект
    $zip = new ZipArchive;
    if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
        foreach ($selectedStudents as $student) {
            $spreadsheet = new Spreadsheet();
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);
            $sheet = $spreadsheet->getActiveSheet();

            // Добавляем данные студента в таблицу
            $row = $sheet->getHighestRow() + 1;
            $sheet->setCellValue('B'.$row, $student['name']);
            $sheet->setCellValue('A'.$row, $student['surname']);
            $sheet->setCellValue('C'.$row, $student['patronymic']);
            $sheet->setCellValue('E'.$row, $student['company_address']);
            $sheet->setCellValue('G'.$row, $student['company_address']);
            $sheet->setCellValue('F'.$row, $student['study_program']);
            $sheet->setCellValue('H'.$row, $student['start_date']);
            // Добавьте остальные поля студента

            $tempFilePath = $tempFolderPath . 'report_' . $student['name'] . '.xlsx';
            $writer = new Xlsx($spreadsheet);

            // Сохраняем изменения в новом Excel файле
            $writer->save($tempFilePath);

            // Добавляем файл в архив
            $zip->addFile($tempFilePath, 'report_' . $student['name'] . '.xlsx');
        }

        $zip->close();

        // Отправляем архив клиенту для скачивания
        return response()->download($zipFilePath, 'report_archive.zip')->deleteFileAfterSend();
    } else {
        return response()->json(['error' => 'Не удалось создать zip-архив'], 500);
    }
}
    public function generateDocument3($studentId)
    {
        // Получение данных студента из базы данных
        $student = Student::find($studentId);
    
        // Проверка, найден ли студент
        if (!$student) {
            return response()->json(['message' => 'Студент не найден'], 404);
        }
    
        // Путь к шаблону документа
        $templatePath = public_path('templates/anketa_template.docx');
    
        // Путь для сохранения созданного документа
        $outputPath = public_path('generated_documents/anketa.docx');
    
        // Инициализация TemplateProcessor с указанием пути к шаблону
        $templateProcessor = new TemplateProcessor($templatePath);
        $birthdateFormatted = date('d-m-Y', strtotime($student->birthdate));
        // Замена тегов в шаблоне на данные студента
        
        $templateProcessor->setValue("{name}", $student->name);
        $templateProcessor->setValue("{surname}", $student->surname);
        $templateProcessor->setValue("{patronymic}", $student->patronymic);
        $templateProcessor->setValue("{course}", $student->course);
        $templateProcessor->setValue("{education_form}",  $student->education_form);
        $templateProcessor->setValue("{birthdate}", $birthdateFormatted);
        $templateProcessor->setValue("{study_program}", $student->study_program);
        $templateProcessor->setValue("{university}", $student->university);
        $templateProcessor->setValue("{company_phone}", $student->company_phone);
        $templateProcessor->setValue("{Адрес_Регистрации}", $student->Адрес_Регистрации);
 
     




     
        // Сохранение созданного документа
        $templateProcessor->saveAs($outputPath);
        
    
        // Отправка созданного документа в ответе
        return response()->download($outputPath)->deleteFileAfterSend();
    }
    
    public function destroy($id)
    {
        $student = Student::find($id);

        if ($student) {
            $student->delete();
            return response()->json(['message' => 'Student deleted']);
        } else {
            return response()->json(['message' => 'Student not found'], 404);
        }
    }
}