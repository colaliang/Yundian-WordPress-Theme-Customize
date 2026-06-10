from html.parser import HTMLParser
import sys

class DivParser(HTMLParser):
    def __init__(self):
        super().__init__()
        self.depth = 0
        self.in_php = False

    def handle_starttag(self, tag, attrs):
        if tag == 'div':
            self.depth += 1
            # print(f"<{tag}> at {self.getpos()}, depth {self.depth}")

    def handle_endtag(self, tag):
        if tag == 'div':
            self.depth -= 1
            # print(f"</{tag}> at {self.getpos()}, depth {self.depth}")

    def handle_comment(self, data):
        if "SECTION 2: Vertical Flow Content" in data:
            print(f"Comment '{data.strip()}' at {self.getpos()}, depth {self.depth}")

if __name__ == "__main__":
    with open(sys.argv[1], 'r', encoding='utf-8') as f:
        content = f.read()
    
    # Very basic strip of PHP tags to not confuse the HTML parser
    import re
    content_no_php = re.sub(r'<\?php.*?\?>', '', content, flags=re.DOTALL)
    
    parser = DivParser()
    parser.feed(content_no_php)
    print(f"Final depth: {parser.depth}")
