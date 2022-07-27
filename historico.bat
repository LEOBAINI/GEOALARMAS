@echo off
if exist "temporalHist.txt" (
    echo "paciencia... trabajando"
) else (
echo "trabajando" > temporalHist.txt
php async.php historico
del temporalHist.txt
)
