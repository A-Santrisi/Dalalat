import torch
from transformers import ElectraTokenizer, ElectraForQuestionAnswering
import numpy as np
import pandas as pd
import faiss
import re

max_length = 512 # The maximum length of a feature (question and context)
index_path='C:/Users/LEGION/OneDrive - University Of Jordan/Dalalat/Passages Index/passage_embeddings2.index'
model_name = "C:/Users/LEGION/OneDrive - University Of Jordan/Dalalat/QA/QA_Model/" #path to our trained qa model

model=ElectraForQuestionAnswering.from_pretrained(model_name).to('cuda')
tokenizer=ElectraTokenizer.from_pretrained(model_name)


def get_passages(embedded_question):
    # Read the Faiss index from the file
    faiss_index = faiss.read_index(index_path)

    #Query the index
    query_vector = embedded_question
    _ , passage_ids = faiss_index.search(query_vector, k=50)
    passage_ids=[p for p in passage_ids.flatten()]
    return(passage_ids)

def get_answers(question,embedded_question):
    '''
    extracts answers from relevent passages
    '''

    doc=pd.read_csv('C:/Users/LEGION/OneDrive - University Of Jordan/Dalalat/QA/passages.csv')

    answers=[]
    rel_passages_text=[]
    passages=get_passages(embedded_question)
    for docid in passages:
        context=doc['passage'].iloc[docid]
        inputs=tokenizer.encode_plus(question,
                    context,
                    return_tensors="pt",
                    padding="max_length",
                    truncation=True,
                    max_length=max_length,
                    add_special_tokens=True,
                    return_attention_mask=True).to('cuda')
    
        model.eval()
        with torch.no_grad():
                preds=model(**inputs)
                start=torch.argmax(torch.softmax(preds.start_logits,dim=1)).cpu().item()
                end=torch.argmax(torch.softmax(preds.end_logits,dim=1)).cpu().item()
        inputs.to('cpu')
        answer=tokenizer.decode(inputs['input_ids'][0][start:end+1])


        check_answer=re.search(answer,context)
        if '[CLS]' not in answer and answer!="" and answer!=question and '[SEP]' not in answer and '[PAD]' not in answer and check_answer:
            rel_passages_text.append(context)
            answers.append(answer)
            
        else:
            continue
    if len(answers)==0:
          return None
    return ({'relevant_passages' : rel_passages_text, 'answers' : answers})


def main():
    return None

if __name__=='__main__':
    main()