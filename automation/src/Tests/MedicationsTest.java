package Tests;

import static org.testng.Assert.assertEquals;

import java.io.FileInputStream;
import java.util.ArrayList;
import java.util.List;

import org.apache.poi.ss.usermodel.DataFormatter;
import org.apache.poi.xssf.usermodel.XSSFCell;
import org.apache.poi.xssf.usermodel.XSSFRow;
import org.apache.poi.xssf.usermodel.XSSFSheet;
import org.apache.poi.xssf.usermodel.XSSFWorkbook;
import org.openqa.selenium.By;
import org.openqa.selenium.Keys;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.firefox.FirefoxDriver;
import org.testng.annotations.BeforeMethod;
import org.testng.annotations.DataProvider;
import org.testng.annotations.Test;

import Repos.LoginPage;
import Repos.MedicationsPage;
import Repos.SurgicalHistoryPage;
import Repos.threePanelPage;

public class MedicationsTest {

	WebDriver driver ;
	private int rowSearch;
	List<String> medicationsData = new ArrayList<>();

	@DataProvider(name="medications")
	public  Object[][] dataInputFromExcel() throws Exception
	{
		WebDriver driver = new FirefoxDriver();
		XSSFWorkbook workBook; 
		XSSFSheet sheet;
		XSSFRow row;
		int i=0;
		int j=0;
		Object[][] DataCellValues;
		List<String> data = new ArrayList<>();
		int rowSearch=0;

		//HashMap<String, String> hmap = new HashMap<String, String>();
		Boolean value = true;
		System.out.println("got here excel");
		FileInputStream fs = new FileInputStream("C:\\\\Users\\\\astri\\\\Desktop\\\\logindata.xlsx");
		workBook = new XSSFWorkbook(fs);
		sheet = workBook.getSheet("Medications");

		int k=sheet.getLastRowNum();//get the number of rows

		int l=sheet.getRow(0).getLastCellNum();//get the number of columns in first row

		//define a string type two dimensional array
		DataCellValues = new Object[k+1][l];
		for(i=0;i<=k;i++)
		{
			row= sheet.getRow(i);
			System.out.println(row);
			for(j=0;j<l-1;j++)
			{
				XSSFCell cell= row.getCell(j);	
				if(row.getCell(j)==null)
				{
					DataCellValues[i][j]="";
				}
				else
				{
					DataCellValues[i][j]= new DataFormatter().formatCellValue(row.getCell(j));
					System.out.println(DataCellValues[i][j]);
				}


			}
		}
		return DataCellValues;
	}
	@BeforeMethod
	public void SearchData() throws Exception
	{
		System.out.println(rowSearch);
		XSSFWorkbook workBook; 
		XSSFSheet sheet;
		XSSFRow row;
		int i=0;
		int j=0;
		short l = 0;
		Object[][] DataCellValues;

		//HashMap<String, String> hmap = new HashMap<String, String>();
		Boolean value = true;
		System.out.println("got here excel data");
		FileInputStream fs = new FileInputStream("C:\\\\Users\\\\astri\\\\Desktop\\\\logindata.xlsx");
		workBook = new XSSFWorkbook(fs);
		sheet = workBook.getSheet("diagnosisSearch");
		System.out.println("got here excel data");
		int k=sheet.getLastRowNum();//get the number of rows
		System.out.println(k);

		int l1=sheet.getRow(rowSearch).getLastCellNum();//get the number of columns in first row
		System.out.println(l1);
		System.out.println(rowSearch);
		if(rowSearch<=k)

		{

			for(int cellNumber=0; cellNumber<l1;cellNumber++)
			{
				//XSSFCell datainput = sheet.getRow(rowSearch).getCell(cellNumber);//get the number of columns in first row

				medicationsData.add( new DataFormatter().formatCellValue(sheet.getRow(rowSearch).getCell(cellNumber)));
				System.out.println(medicationsData.get(cellNumber));
			}

		}

		rowSearch++;
		System.out.println(rowSearch);
	}


	@Test(dataProvider="medications")
	public void getpatientmedical(String uname,String pass,String Patient,String comment,String value
			) throws Exception
	{

		driver = new FirefoxDriver();

		LoginPage.GoToPage(driver);
		LoginPage.UserName(driver).sendKeys(uname);
		LoginPage.Password(driver).sendKeys(pass);
		LoginPage.Submit(driver).click();


		driver.findElement(By.partialLinkText(Patient)).click();
		Thread.sleep(5000);

		threePanelPage.medicationsTab(driver).click();
		System.out.println(medicationsData.size());

		for (int j=0;j<medicationsData.size();j++)
		{
			System.out.println(j);
			MedicationsPage.menuMedications(driver).sendKeys(medicationsData.get(j));

			Thread.sleep(2000);
			List<WebElement> options = driver.findElements(By.xpath("//ul[@id='select2-search_medications-results']/li"));
			// Loop through the options and select the one that matches
			Thread.sleep(2000);
			int i=0;
			System.out.println(options.size());	
			for (i=0;i<options.size();i++)
			{

				System.out.println(options.get(i).getText()+i);

				if(options.get(i).getText().equals("No results found"))
				{
					MedicationsPage.menuMedications(driver).clear();
				}
				else {
					String option=medicationsData.get(j);
					Thread.sleep(1000);
					if (options.get(i).getText().equals(option)) {
						System.out.println("got here");
						options.get(i).sendKeys(Keys.ENTER);
						break;
					}
					else
					{
						options.get(i).sendKeys(Keys.ARROW_DOWN);
					}

				}

			}

		}
		medicationsData.clear();
		//rowSearch++;
		Thread.sleep(5000);
//		threePanelPage.ordersTab(driver).click();
//		Thread.sleep(5000);
//
//
//		driver.switchTo().alert().dismiss();



		MedicationsPage.MedicationsComment(driver).sendKeys(comment);

//		threePanelPage.backToDashboard(driver).click();
//		Thread.sleep(5000);
//		driver.switchTo().alert().dismiss();
		//driver.findElement(By.partialLinkText(Patient));
		Thread.sleep(5000);
		//threePanelPage.MedicalHistory(driver).click();
		//assertEquals(MedicationsPage.MedicationsComment(driver).getText().contains(comment), true);

		//MedicationsPage.MedicationsComment(driver).clear();
		MedicationsPage.saveMedications(driver).click();
		//MedicationsPage.MedicationsComment(driver).click();

	}
}








