import sys

def trace_divs(filepath):
    with open(filepath, 'r', encoding='utf-8') as f:
        lines = f.readlines()

    stack = []
    for i, line in enumerate(lines):
        line_num = i + 1
        
        # We need a robust way to find opening and closing tags on the same line
        # but let's just do a naive count of <div and </div
        opens = line.count('<div')
        closes = line.count('</div')
        
        for _ in range(opens):
            stack.append(line_num)
            
        for _ in range(closes):
            if stack:
                popped = stack.pop()
                if line_num >= 575 and line_num <= 585:
                    print(f"Line {line_num} closed div from line {popped}")
            
        if line_num == 56 or line_num == 60 or line_num == 441:
            print(f"Line {line_num} opened div, current stack depth: {len(stack)}")
            
        if line_num == 579:
            print(f"At line 579, stack: {stack}")

if __name__ == "__main__":
    trace_divs(sys.argv[1])
