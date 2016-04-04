cd ../

echo "" > todo.txt

git grep '@todo' | while read -r line ; do
	echo $line | sed -e 's/:.* @todo /:\n\t/g' | sed -e 's/-->//g' >> todo.txt
	echo "" >> todo.txt
done
