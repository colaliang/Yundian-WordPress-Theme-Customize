import re
import sys

def check_divs(filepath):
    with open(filepath, 'r', encoding='utf-8') as f:
        lines = f.readlines()

    stack = []
    for i, line in enumerate(lines):
        line_num = i + 1
        
        div_opens = re.findall(r'<div\b[^>]*>', line)
        div_closes = re.findall(r'</div\s*>', line)
        
        for _ in div_opens:
            stack.append(line_num)
        
        for _ in div_closes:
            if stack:
                stack.pop()
        
        if "SECTION 2: Vertical Flow Content" in line:
            print(f"At line {line_num}, stack depth is {len(stack)}: {stack}")

if __name__ == "__main__":
    check_divs(sys.argv[1])
