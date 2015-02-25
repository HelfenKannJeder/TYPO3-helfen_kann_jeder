#!/bin/bash
# See also http://www.derhansen.de/2014/06/standalone-unit-and-functional-tests.html

# Go to basic typo3 path
cd ../../../../../

# Clean up
rm -rf typo3temp/functional-*

echo;
echo "Running unit tests";
if [[ "$COVERAGE" == "1" ]]; then
	phpunit --coverage-clover=coverage.clover --colors -c typo3conf/ext/helfen_kann_jeder/Tests/Build/UnitTests.xml
else
	phpunit --colors -c typo3conf/ext/helfen_kann_jeder/Tests/Build/UnitTests.xml
fi

echo;
echo "Running functional tests";
if [[ "$COVERAGE" == "1" ]]; then
	find . -wholename '*/typo3conf/ext/helfen_kann_jeder/Tests/Functional/*Test.php' | parallel --gnu 'echo; echo "Running functional test suite {}"; phpunit --coverage-clover={}functionaltest-coverage.clover --colors -c typo3conf/ext/helfen_kann_jeder/Tests/Build/FunctionalTests.xml {}'
else
	find . -wholename '*/typo3conf/ext/helfen_kann_jeder/Tests/Functional/*Test.php' | parallel --gnu 'echo; echo "Running functional test suite {}"; phpunit --colors -c typo3conf/ext/helfen_kann_jeder/Tests/Build/FunctionalTests.xml {}'
fi
