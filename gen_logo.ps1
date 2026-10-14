Add-Type -AssemblyName System.Drawing
$navy = [System.Drawing.Color]::FromArgb(27,45,74)
$orange = [System.Drawing.Color]::FromArgb(246,139,30)
function New-DatanetLogo([int]$s, [string]$out){
  $bmp = New-Object System.Drawing.Bitmap $s,$s
  $g = [System.Drawing.Graphics]::FromImage($bmp)
  $g.SmoothingMode = [System.Drawing.Drawing2D.SmoothingMode]::AntiAlias
  $g.Clear([System.Drawing.Color]::White)
  $L = [int]($s * 0.135)
  $top = [int]($s * 0.155)
  $bot = [int]($s * 0.845)
  $Cy = [int]($s * 0.5)
  $Cx = [int]($s * 0.485)
  $R = [int](($bot - $top)/2)
  $outer = New-Object System.Drawing.Drawing2D.GraphicsPath
  $outer.AddLine($L, $top, $Cx, $top)
  $outer.AddArc($Cx - $R, $Cy - $R, 2*$R, 2*$R, -90, 180)
  $outer.AddLine($Cx, $bot, $L, $bot)
  $outer.CloseFigure()
  $g.FillPath((New-Object System.Drawing.SolidBrush $navy), $outer)
  $T = [int]($s * 0.135)
  $Li = [int]($s * 0.265)
  $Ti = $top + $T
  $Bi = $bot - $T
  $Ri = [int](($Bi - $Ti)/2)
  $Cyi = [int](($Ti+$Bi)/2)
  $Cxi = $Cx
  $inner = New-Object System.Drawing.Drawing2D.GraphicsPath
  $inner.AddLine($Li, $Ti, $Cxi, $Ti)
  $inner.AddArc($Cxi - $Ri, $Cyi - $Ri, 2*$Ri, 2*$Ri, -90, 180)
  $inner.AddLine($Cxi, $Bi, $Li, $Bi)
  $inner.CloseFigure()
  $g.FillPath([System.Drawing.Brushes]::White, $inner)
  $clipRect = New-Object System.Drawing.Rectangle 0, ([int]($s*0.485)), $s, $s
  $prev = $g.Clip
  $g.SetClip($clipRect)
  $g.FillPath((New-Object System.Drawing.SolidBrush $orange), $outer)
  $g.FillPath([System.Drawing.Brushes]::White, $inner)
  $g.Clip = $prev
  $bmp.Save($out, [System.Drawing.Imaging.ImageFormat]::Png)
  $g.Dispose(); $bmp.Dispose()
  Write-Host "Generated $out $s"
}
New-DatanetLogo 512 'C:\laragon\www\data-payroll\public\icon-512.png'
New-DatanetLogo 192 'C:\laragon\www\data-payroll\public\icon-192.png'
New-DatanetLogo 512 'C:\laragon\www\data-payroll\public\logo.png'
Copy-Item 'C:\laragon\www\data-payroll\public\logo.png' 'C:\laragon\www\data-payroll\public\logo-datanet.png' -Force
Get-ChildItem 'C:\laragon\www\data-payroll\public' -Filter '*.png' | Select-Object Name,Length | Format-Table -AutoSize
