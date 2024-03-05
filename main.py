from QA.QAPipeline import *
from QuestionEncoding.Encoding import *
import sys

import re
import string
from farasa.stemmer import FarasaStemmer
import json


def clean(text):
    text = re.sub(r"http\S+", " ", text)  # remove urls
    text = re.sub(r"@[\w]*", " ", text)  # remove handles
    text = re.sub(r"\t", " ", text)  # remove tabs
    text = re.sub(r"\n", " ", text)  # remove line jump
    text = text.strip()
    return text

def ar_remove_stop_words(sentence):
    terms=[]
    stopWords= set({'من', 'الى', 'إلى', 'عن', 'على', 'في', 'حتى'})
    for term in sentence.split() :
        if term not in stopWords :
            terms.append(term)
    return " ".join(terms)

def remove_punc(text):
        exclude = set(string.punctuation)
        # Arabic punctuation
        exclude.add('،')
        exclude.add('؛')
        exclude.add('؟')
        return ''.join(ch for ch in text if ch not in exclude)

def white_space_fix(text):
    return ' '.join(text.split())

def normalize_arabic(text):
    text = re.sub("[إأٱآا]", "ا", text)
    text = re.sub("ى", "ي", text)
    text = re.sub("ؤ", "ء", text)
    text = re.sub("ئ", "ء", text)
    text = re.sub("ة", "ه", text)
    return(text)

def ar_stem(text,stemmer):
    stemmed=stemmer.stem(text)
    return stemmed

def preprocess_question(question,stemmer):
    text=question
    text=white_space_fix(ar_remove_stop_words(remove_punc(text)))
    text = ar_stem(text,stemmer)
    #text = normalize_arabic(text)
    return text

def main(question):
        stemmer=FarasaStemmer()
        query=preprocess_question(question,stemmer)
        query_embedded=embed_question(query)
        ans=get_answers(question,query_embedded)
        return ans

if __name__=='__main__':
    #  print(main('الدليل على وجوب اتباع الانبياء و الرسل'))
    if len(sys.argv)>1:
        question=sys.argv[1]
        result=main(question)
        if result==None:
            print(json.dumps(result))
        else:
            #Post processing the results
            print(json.dumps(result))