import os
import re

directory = r"d:\internship work\leogroup main website"

pattern = re.compile(r'\bmysql_(query|fetch_array|fetch_assoc|num_rows|connect|select_db|error|real_escape_string|close|insert_id|affected_rows)\b')

changed_files = 0
total_replacements = 0

for root, _, files in os.walk(directory):
    for file in files:
        if file.endswith(".php"):
            filepath = os.path.join(root, file)
            
            # Skip the shim file itself
            if file == "leo_mysql_shim.php":
                continue
                
            with open(filepath, 'r', encoding='utf-8', errors='ignore') as f:
                content = f.read()
                
            new_content, count = pattern.subn(r'leo_mysql_\1', content)
            
            if count > 0:
                with open(filepath, 'w', encoding='utf-8') as f:
                    f.write(new_content)
                changed_files += 1
                total_replacements += count
                print(f"Updated {filepath} ({count} replacements)")

print(f"\nMigration complete. Changed {total_replacements} instances across {changed_files} files.")
