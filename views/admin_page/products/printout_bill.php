<html>
<head>
    <title>Faktur Pembayaran</title>
    <style>
        html {
            margin: 10pt
        }
        #tabel {
            font-size:4pt;
            border-collapse:collapse;
        }
        #tabel td {
            padding-left:5px;
            border: 1px solid black;
        }

        hr { 
            display: block;
            margin-top: 0.5em;
            margin-bottom: 0.5em;
            margin-left: auto;
            margin-right: auto;
            /* border-style: inset; */
            border-width: 0.5px;
        }
    </style>
</head>
<body style='font-family:tahoma; font-size:3pt; width:120pt;'>
    <center>
        <table style='width:100%; font-size:6pt; font-family:calibri; border-collapse: collapse;margin-bottom: 10px' border = '0'>
            <td width='70%' align='CENTER' vertical-align:top'>
                <span style='color:black;'>
                    <b>MOCASH</b></br>JL XXXXXXXXXXX XXXXXXX
                </span>
                </br>
                <span style='font-size:4pt'>No. : <?= isset($this->cart['id']) ? $this->cart['id'] : 'N/A' ?>, <?= date('d M Y') ?> (user: <?= $this->user['fullname'] ?>), <?= date('H:i:s') ?></span></br>
            </td>
        </table>
        <table cellspacing='0' cellpadding='0' style='width:120pt; font-size:4pt; font-family:calibri;  border-collapse: collapse;' border='0'>
            <tr align='center'>
                <td width='30%'>Item</td>
                <td width='30%'>Price</td>
                <td width='10%'>Qty</td>
                <td width='30%'>Total</td>
                <tr>
                    <td colspan='4'><hr></td>
                </tr>
            </tr>
            <?php foreach($this->cart['detail'] as $c){ ?>
                <tr>
                    <td style='vertical-align:top'><?= $c['nama'] ?></td>
                    <td style='vertical-align:top; text-align:right; padding-right:10px'><?= number_format($c['harga'], 2, ',', '.') ?></td>
                    <td style='vertical-align:top; text-align:right; padding-right:10px'><?= $c['jumlah'] ?></td>
                    <td style='text-align:right; vertical-align:top'><?= number_format($c['total'], 2, ',', '.') ?></td>
                </tr>
            <?php } ?>
            <tr>
                <td colspan='4'><hr></td>
            </tr>
            <tr>
                <td colspan = '3'><div style='text-align:right; color:black'>Total : </div></td>
                <td style='text-align:right; font-size:6pt; color:black'><?= number_format(isset($this->cart['total_harga']) ? $this->cart['total_harga'] : 0, 2, ',', '.') ?></td>
            </tr>
            <tr>
                <td colspan = '3'><div style='text-align:right; color:black'>Cash : </div></td>
                <td style='text-align:right; font-size:6pt; color:black'><?= number_format($this->cart['pembayaran'], 2, ',', '.') ?></td>
            </tr>
            <tr>
                <td colspan = '3'><div style='text-align:right; color:black'>Change : </div></td>
                <td style='text-align:right; font-size:6pt; color:black'><?= number_format($this->cart['sisa_pembayaran'], 2, ',', '.') ?></td>
            </tr>
        </table>
        </br>
        <table style='width:120pt; font-size:4pt;' cellspacing='2'>
            <tr>
                <td align='center'>****** TERIMAKASIH ******</td>
            </tr>
        </table>
    </center>
</body>
</html>