@echo off
if exist "temporalReal.txt" (
    echo "paciencia... trabajando"
) else (
echo "trabajando" > temporalReal.txt
php async.php realtime
del temporalReal.txt
)

