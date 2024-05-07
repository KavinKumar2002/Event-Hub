<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use setasign\Fpdi\Fpdi;


class CertificateController extends Controller
{
    public function generateCertificate(Request $request)
    {
        $name = $request->input('name');
       
        // Import existing PDF template
        $pdf = new Fpdi();
        $pdf->setSourceFile(public_path('.pdf'));
        $templateId = $pdf->importPage(1);

        // Add dynamic content
        $pdf->AddPage();
        $pdf->useTemplate($templateId);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(50, 100);
        $pdf->Cell(0, 10, "Certificate of Completion", 0, 1, 'C');
        $pdf->SetXY(50, 120);
        $pdf->Cell(0, 10, "This certifies that $name has successfully completed the course.", 0, 1, 'C');

        // Output the PDF
        return $pdf->Output('certificate.pdf', 'D');
    }
}
