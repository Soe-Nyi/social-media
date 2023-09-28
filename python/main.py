import pandas as pd
import pymysql as pm
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import linear_kernel
import warnings

# Suppress pandas warning
warnings.filterwarnings("ignore", category=UserWarning)

# Load post data from MySQL database into a DataFrame
# You might need to install a MySQL connector for Python
# and replace 'your_connection_parameters' with actual parameters.
conn = pm.connect(host='localhost', user='root',
                       password='', db='social-media')
query = "SELECT * FROM posts WHERE usr_id = 2"
df = pd.read_sql_query(query, conn)

# Rest of your code...


# Create a TF-IDF vectorizer and compute the TF-IDF matrix
tfidf_vectorizer = TfidfVectorizer(stop_words='english')
tfidf_matrix = tfidf_vectorizer.fit_transform(df['content'])

# Compute the cosine similarity matrix
cosine_sim = linear_kernel(tfidf_matrix, tfidf_matrix)

# Map post titles to post IDs for later reference
post_id_map = pd.Series(df.index, index=df['id'])

# Function to get recommendations based on post content


def get_recommendations(post_id, cosine_sim=cosine_sim):
    idx = post_id_map[post_id]
    sim_scores = list(enumerate(cosine_sim[idx]))
    sim_scores = sorted(sim_scores, key=lambda x: x[1], reverse=True)
    sim_scores = sim_scores[1:6]  # Get the top 5 most similar posts
    post_indices = [i[0] for i in sim_scores]
    return df['id'].iloc[post_indices]

id=int(input('insert id : '))
recommended_post_ids = get_recommendations(id)
print(recommended_post_ids)