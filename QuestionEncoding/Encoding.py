import torch.nn as nn
import torch
from sentence_transformers import SentenceTransformer

model_name='C:/Users/LEGION/OneDrive - University Of Jordan/Dalalat/QuestionEncoding/Encoder_Model_run2/'# path to our trained model
max_seq_len = 128

def embed_question(question):
    '''
    embed  question to be used as a query
    '''
    encoder=SentenceTransformer(model_name,max_seq_len,device='cuda')
    embedded_question=encoder.encode([question])
    return embedded_question

if __name__=='__main__':
    print('Abduelelah')