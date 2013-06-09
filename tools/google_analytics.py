import os

def readgoogle_analytics():
    fh = open("google_analytics.txt", "r");
    data = ''
    while 1:
        line = fh.readline()
        data+=line
        if not line:
            break
    fh.close();
    return data


def add_google_analytics(file):
    data = readgoogle_analytics();
    beforeread = '';
    fh = open("footer.php", "r");
    while 1:
        line = fh.readline()
        if not line:
            break
        if "</body>" in line:
            beforeread+=data
        beforeread+=line
    fh.close();
    text_file = open("footer.php", "w")
    text_file.write(beforeread)
    text_file.close()

def traverse(dir):
    list = [];
    for name in os.listdir(dir):
           list.append(dir+name);

    # filter element in header.php
    list = filter(lambda s: os.path.isdir(s) or s.endswith('footer.php'), list)
    for name in list:
        if os.path.isdir(name):
            print(name+"/");
        else:
            add_google_analytics(name);
'''
mian function start here
'''
traverse('H:/wamp/www/utsp_vlab/');
