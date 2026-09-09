<?php
/**
 * Public report "lista-ramais.pdf" (sectors ordered by name).
 */

date_default_timezone_set('America/Sao_Paulo');
require_once __DIR__ . '/../util/fpdf/fpdf.php';
require_once "conecta-banco.php";

class PDF extends FPDF
{
    function Header()
    {
        $this->Image(__DIR__ . '/../imagem/ipmjp.jpg', 7, 2, 30);
        $this->SetFont('Arial', 'I', 16);
        $this->Cell(80);
        $this->Cell(30, 12, "Listagem de Ramais", 0, 1, 'C');
        $this->Ln(1);

        $this->SetFont('Arial', 'B', 12);
        $this->SetFillColor(205, 92, 92);
        $this->SetTextColor(0);
        $this->SetLineWidth(1);

        $this->Cell(75, 6, 'SETOR', 0, 0, 'C', true);
        $this->Cell(30, 6, 'RAMAL', 0, 0, 'C', true);
        $this->Cell(85, 6, 'RESPONSÁVEL', 0, 0, 'C', true);
        $this->Ln();
    }

    /** Converts UTF-8 to the Latin-1 encoding used by core fonts (PHP 8.2 safe). */
    public function Cell($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '')
    {
        if (function_exists('mb_convert_encoding')) {
            $txt = mb_convert_encoding($txt, 'ISO-8859-1', 'UTF-8');
        } elseif (function_exists('utf8_decode')) {
            $txt = utf8_decode($txt);
        }
        parent::Cell($w, $h, $txt, $border, $ln, $align, $fill, $link);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Página ' . $this->PageNo() . '/{nb}    ' . date('d/m/Y, H:i:s'), 0, 0, 'C');
    }

    function Body()
    {
        $conexao = obter_conexao();

        $this->SetFillColor(200, 200, 200);
        $this->SetTextColor(0);
        $this->SetFont('Times', '', 10);

        $colore = false;

        try {
            $stmt = $conexao->prepare('SELECT setor, ramal, responsavel FROM setores ORDER BY setor');
            $stmt->execute();

            foreach ($stmt->fetchAll() as $row) {
                $ramal = ($row['ramal'] == 0) ? '' : $row['ramal'];

                $this->Cell(75, 6, (string)$row['setor'], '', 0, 'L', $colore);
                $this->Cell(30, 6, (string)$ramal, '', 0, 'C', $colore);
                $this->Cell(85, 6, (string)($row['responsavel'] ?? ''), '', 0, 'C', $colore);
                $this->Ln();

                $colore = !$colore;
            }
        } catch (Exception $e) {
            error_log('[ramais] Erro ao gerar PDF: ' . $e->getMessage());
        }
    }
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Body();
$pdf->Output('lista-ramais.pdf', 'D');
