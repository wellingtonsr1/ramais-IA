<?php
    date_default_timezone_set('America/Sao_Paulo');
    require('../util/fpdf/fpdf.php'); // inclui a classe FPDF
            
    class PDF extends FPDF{
        // cabeçalho
        function Header(){
            // Logo
            $this->Image('../imagem/ipmjp.jpg', 7, 2, 30);
            // Arial Itálico 15
            $this->SetFont('Arial','I',16);
            // Move para direita
            $this->Cell(80);
            // Título
            $this->Cell(30, 12, "Listagem de Ramais", 0, 1, 'C');
            // Quebra de linha
            $this->Ln(1);

            // Define cor de preenchimento,
            // cor de texto e espessura da linha
            $this->SetFont('Arial','B', 12);
            $this->SetFillColor(205, 92, 92);
            $this->SetTextColor(000);
            $this->SetLineWidth(1);

            // Adiciona células 
            $this->Cell(75, 6, 'SETOR', 0, 0, 'C', true);
            $this->Cell( 30, 6, 'RAMAL',   0, 0, 'C', true);
            $this->Cell( 85, 6, 'RESPONSÁVEL',   0, 0, 'C', true);

            // Quebra de linha
            $this->Ln();
        }

        //Método da class fpdf sobrescrito para resolver o problema de acentuação. Também pode ser usado
        //o iconv(mb_detect_encoding($str, 'windows-1252', $str) caso não dê certo
        public function Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link=''){
            $txt = utf8_decode($txt);
            parent::Cell($w, $h, $txt, $border, $ln, $align, $fill, $link);
        }

        // Rodapé
        function Footer(){  
            // Position at 1.5 cm from bottom
            $this->SetY(-15);
            // Arial Itálico 8
            $this->SetFont('Arial', 'I', 8);
            // Número de página
            $this->Cell(0, 10, 'Página '.$this->PageNo().'/{nb}', 0, 0, 'C');
            $this->Cell(0, 10, date("d/m/Y, H:i:s"), 0, 0, 'R');
        }

        // Conteúdo
        function Body(){
            include_once "conecta-banco.php";
          
            // Define a query de consulta
            $sql = 'SELECT setor, ramal, responsavel from setores ORDER by setor';

            // executa a instrução SQL 
            $result = $conexao->query($sql);

            // Define cor de fundo, do
            // texto e fonte dos dados
            $this->SetFillColor(200,200,200);
            $this->SetTextColor(0);
            $this->SetFont('Times', '', 10);

            $colore = FALSE;
            
            // Percorre os resultados
            foreach ($result as $row){   
                $row['ramal'] = $row['ramal'] == 0 ? '' : $row['ramal'];
                
                $this->Cell(75, 6, $row['setor'], '', 0, 'L', $colore);
                $this->Cell(30, 6, $row['ramal'],  '', 0, 'C', $colore);
                $this->Cell(85, 6, $row['responsavel'], '', 0, 'C', $colore);
            
                // Quebra de linha
                $this->Ln();

                // Inverte cor de fundo
                $colore = !$colore;
            }  
        }
    }

    // Instancia a classe
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->Body();
    $pdf->Output('lista-ramais.pdf', 'D');
?>